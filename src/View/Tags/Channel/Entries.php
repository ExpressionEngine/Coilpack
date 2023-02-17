<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Category\Category;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\TypedParameter as Parameter;
use Expressionengine\Coilpack\View\ModelTag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Entries extends ModelTag implements ConvertsToGraphQL
{
    public function __construct()
    {
        $this->query = ChannelEntry::query();
    }

    public function defineParameters(): array
    {
        return [
            new Parameter([
                'name' => 'author_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Member ID',
            ]),
            new Parameter([
                'name' => 'category',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Category url title',
            ]),
            new Parameter([
                'name' => 'category_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Category ID',
            ]),
            new Parameter([
                'name' => 'channel',
                'type' => 'string',
                'description' => 'From which channel to show the entries',
            ]),
            new Parameter([
                'name' => 'entry_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Entry ID',
            ]),
            new Parameter([
                'name' => 'group_id',
                'type' => 'string',
                'description' => 'Limit entries to the specified Member Role ID',
            ]),
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of entries',
            ]),
            new Parameter([
                'name' => 'offset',
                'type' => 'integer',
                'description' => 'Offsets the display by X number of entries',
            ]),
            new Parameter([
                'name' => 'orderby',
                'type' => 'string',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'boolean',
                'description' => 'Sets the display order of the entries',
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'The sort order (asc/desc)',
            ]),
            new Parameter([
                'name' => 'start_on',
                'type' => 'string',
                'description' => 'A particular date/time on which to start the entries',
            ]),
            new Parameter([
                'name' => 'status',
                'type' => 'string',
                'description' => 'Restrict to entries with a particular status',
            ]),
            new Parameter([
                'name' => 'stop_before',
                'type' => 'string',
                'description' => '',
            ]),
            new Parameter([
                'name' => 'site',
                'type' => 'string',
                'description' => '',
                'defaultValue' => ee()->config->item('site_id'),
            ]),
            new Parameter([
                'name' => 'url_title',
                'type' => 'string',
                'description' => 'Limits the query by an entry\'s url_title',
            ]),
            new Parameter([
                'name' => 'username',
                'type' => 'string',
                'description' => 'Limits the query by username',
            ]),
            new Parameter([
                'name' => 'search',
                // 'prefix' => 'Channel_Entries',
                'description' => 'Search for entries matching a certain criteria',
                'type' => function () {
                    return app(FieldtypeManager::class)->allFields()->map(function ($field) {
                        return new Parameter([
                            'name' => $field->field_name,
                            'type' => 'string',
                            'description' => $field->field_instructions,
                        ]);
                    })->toArray();
                },
            ]),
        ];
    }

    public function getArgumentFallback($key, $value)
    {
        return new FilterArgument($value);
    }

    public function getFixedOrderArgument($order)
    {
        return $order;
    }

    public function getSearchArgument($search)
    {
        foreach ($search as $field => $value) {
            $search[$field] = new FilterArgument($value);
        }

        return $search;
    }

    public function run()
    {
        // Author
        $this->query->when($this->hasArgument('author'), function ($query) {
            $this->getArgument('author')->addQuery($query, 'author_id');
        });

        // Entry ID
        $this->query->when($this->hasArgument('entry_id'), function ($query) {
            $this->getArgument('entry_id')->addQuery($query, 'entry_id');
        });

        // Site ID
        $this->query->when($this->hasArgument('site_id'), function ($query) {
            $this->getArgument('site_id')->addQuery($query, 'site_id');
        });

        // URL Title
        $this->query->when($this->hasArgument('url_title'), function ($query) {
            $this->getArgument('url_title')->addQuery($query, 'url_title');
        });

        // Status
        $this->query->when($this->hasArgument('status'), function ($query) {
            $this->getArgument('status')->addQuery($query, 'status');
        });

        // Channel
        $this->query->when($this->hasArgument('channel'), function ($query) {
            $query->whereHas('channel', function ($query) {
                return $this->getArgument('channel')->addQuery($query, 'channel_name');
            });
        });

        // Category
        $this->query->when($this->hasArgument('category'), function ($query) {
            $query->whereHas('categories', function ($query) {
                return $this->getArgument('category')->addQuery($query, 'cat_url_title');
            });
        });

        // Category ID
        $this->query->when($this->hasArgument('category_id'), function ($query) {
            $query->whereHas('categories', function ($query) {
                return $this->getArgument('category_id')->addQuery($query, (new Category)->qualifyColumn('cat_id'));
            });
        });

        // Fixed Order
        $this->query->when($this->hasArgument('fixed_order'), function ($query) {
            $order = $this->getArgument('fixed_order');
            $query->whereIn('entry_id', $order);
            $query->orderByRaw('FIELD(entry_id, '.implode(',', $order).')');
        });

        // Dynamic
        if ($this->hasArgument('dynamic')) {
            $lastSegment = last(request()->segments());

            $this->setLimitArgument(1);

            $this->query->when(is_int($lastSegment), function ($query) use ($lastSegment) {
                $query->where('entry_id', (int) $lastSegment);
            }, function ($query) use ($lastSegment) {
                $query->where('url_title', $lastSegment);
            });
        }

        return parent::run();
    }

    public function toGraphQL(): array
    {
        return [
            'type' => Type::listOf(GraphQL::type('ChannelEntry')),
        ];
    }
}
