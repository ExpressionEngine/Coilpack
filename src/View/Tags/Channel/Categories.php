<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Category\Category as CategoryModel;
use Expressionengine\Coilpack\Models\Channel\Channel;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\Support\Arguments\ListArgument;
use Expressionengine\Coilpack\Support\Arguments\SearchArgument;
use Expressionengine\Coilpack\Support\Arguments\Term;
use Expressionengine\Coilpack\TypedParameter as Parameter;
use Expressionengine\Coilpack\View\ModelTag;
use GraphQL\Type\Definition\Type;

class Categories extends ModelTag implements ConvertsToGraphQL
{
    protected $fieldtypeManager;

    public function __construct()
    {
        $this->query = CategoryModel::query();
        $this->fieldtypeManager = app(FieldtypeManager::class);
    }

    public function defineParameters(): array
    {
        return [
            new Parameter([
                'name' => 'category',
                'type' => 'string',
                'description' => 'Specify titles of which categories will be included in the list',
            ]),
            new Parameter([
                'name' => 'category_id',
                'type' => 'string',
                'description' => 'Specify IDs of which categories will be included in the list',
            ]),
            new Parameter([
                'name' => 'group',
                'type' => 'string',
                'description' => 'Limit the categories to a specific Category Group Name',
            ]),
            new Parameter([
                'name' => 'group_id',
                'type' => 'string',
                'description' => 'Limit the categories to a specific Category Group ID',
            ]),
            new Parameter([
                'name' => 'channel',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Channel short name',
            ]),
            new Parameter([
                'name' => 'orderby',
                'type' => 'string',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'parent_only',
                'type' => 'boolean',
                'description' => 'Display only parent categories',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'show_empty',
                'type' => 'boolean',
                'description' => 'Determines whether or not categories that contain no entries are displayed',
                'defaultValue' => true,
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'boolean',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'The sort order (asc/desc)',
            ]),
            new Parameter([
                'name' => 'status',
                'type' => 'string',
                'description' => 'Restrict to entries with a particular status',
            ]),

            // new Parameter([
            //     'name' => 'style',
            //     'type' => 'string',
            //     'description' => 'There are two list "styles" for your categories: "nested" and "linear".',
            //     'defaultValue' => 'linear',
            // ]),
        ];
    }

    public function getArgumentFallback($key, $value)
    {
        if (in_array($key, ['channel', 'group', 'group_id'])) {
            return new FilterArgument($value);
        }

        return $value;
    }

    public function getOrderbyArgument($value)
    {
        return new ListArgument($value);
    }

    public function getSortArgument($value)
    {
        $argument = new ListArgument($value);

        $argument->terms->map(function ($term) {
            if (in_array(strtolower($term->value), ['asc', 'desc'])) {
                return $term;
            }

            return new Term('desc');
        });

        return $argument;
    }

    public function getSearchArgument($search)
    {
        foreach ($search as $field => $value) {
            $search[$field] = new SearchArgument($value);
        }

        return $search;
    }

    public function run()
    {
        // Site ID
        $this->query->when($this->hasArgument('site_id'), function ($query) {
            $this->getArgument('site_id')->addQuery($query, 'site_id');
        });

        // Show Empty
        $this->query->when(! $this->getArgument('show_empty')->value, function ($query) {
            $query->whereHas('entries');
        });

        // Parent Only
        $this->query->when($this->getArgument('parent_only')->value, function ($query) {
            $query->where('parent_id', '>', 0);
        });

        // Channel - Sets Group ID Argument
        if ($this->hasArgument('channel')) {
            $groups = tap(Channel::select('cat_group'), function ($query) {
                $this->getArgument('channel')->addQuery($query, 'channel_name');
            })->get()->map(function ($channel) {
                return explode('|', $channel->cat_group);
            })->collapse()->implode('|');

            $this->setArgument('group_id', empty($groups) ? 0 : $groups);
        }

        // Category
        $this->query->when($this->hasArgument('category'), function ($query) {
            $this->getArgument('category')->addQuery($query, 'cat_url_title');
        });

        // Category ID
        $this->query->when($this->hasArgument('category_id'), function ($query) {
            $this->getArgument('category_id')->addQuery($query, 'cat_id');
        });

        // Category Group
        $this->query->when($this->hasArgument('group'), function ($query) {
            $this->getArgument('group')->addRelationshipQuery($query, 'group', 'group_name');
        });

        // Category Group ID
        $this->query->when($this->hasArgument('group_id'), function ($query) {
            $this->getArgument('group_id')->addQuery($query, 'group_id');
        });

        // Search
        if ($this->hasArgument('search')) {
            foreach ($this->getArgument('search') as $field => $argument) {
                if ($this->fieldtypeManager->hasField($field)) {
                    $field = $this->fieldtypeManager->getField($field);
                    $alias = "search_{$field->field_name}";
                    $column = "$alias.field_id_{$field->field_id}";

                    $this->query->joinFieldDataTable($field, $alias);
                    $argument->addQuery($this->query, $column);
                } else {
                    $argument->addQuery($this->query, $field);
                }
            }
        }

        // Orderby and Sort Direction
        if ($this->hasArgument('orderby')) {
            $directions = $this->hasArgument('sort') ? $this->getArgument('sort')->terms->map->value->toArray() : ['desc'];
            $fields = $this->getArgument('orderby');
            foreach ($fields->terms as $index => $field) {
                $direction = isset($directions[$index]) ? $directions[$index] : end($directions);
                $field = $field->value;
                if ($this->fieldtypeManager->hasField($field)) {
                    $this->query->orderByCustomField($field, $direction);
                } else {
                    $this->query->orderBy($this->query->qualifyColumn($field), $direction);
                }
            }
        }

        return parent::run();
    }

    public function toGraphQL(): array
    {
        return [
            'type' => Type::listOf(GraphQL::type('Category')),
        ];
    }
}
