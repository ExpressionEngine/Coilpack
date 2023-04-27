<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\FieldtypeManager;
use ExpressionEngine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\Support\Arguments\ListArgument;
use Expressionengine\Coilpack\Support\Arguments\SearchArgument;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;

class RelationshipPresenter extends Presenter
{
    use HasArgumentsAndParameters;

    private $fieldtypeManager;

    public function __construct()
    {
        $this->fieldtypeManager = app(FieldtypeManager::class);
    }

    public function present(FieldContent $content, $arguments)
    {
        $isGrid = $content->field->field_type === 'grid';
        $isFluid = $content->hasAttribute('fluid_field');
        $fluidFieldId = ($isFluid) ? $content->fluid_field_data_id : 0;
        $this->arguments($arguments);

        $query = ChannelEntry::query();

        if ($content->entry->isPreview()) {
            $query->whereIn('entry_id', $content->data['data'] ?? [0]);
        } else {
            $query->select('channel_titles.*')
                ->join('relationships', 'entry_id', '=', 'child_id')
                ->when($isFluid, function ($query) use ($fluidFieldId) {
                    $query->where('relationships.fluid_field_data_id', $fluidFieldId);
                })
                ->when($isGrid, function ($query) use ($content) {
                    $query->where('relationships.parent_id', $content->entry_id)
                        ->where('relationships.grid_field_id', $content->field->field_id)
                        ->where('relationships.grid_row_id', $content->grid_row_id)
                        ->where('relationships.grid_col_id', $content->grid_col_id);
                }, function ($query) use ($content) {
                    $query->where('relationships.parent_id', $content->entry_id)
                        ->where('relationships.field_id', $content->field->field_id);
                })
                ->orderBy('order');
        }

        // Author
        $query->when($this->hasArgument('author'), function ($query) {
            $this->getArgument('author')->addQuery($query, 'author_id');
        });

        // Entry ID
        $query->when($this->hasArgument('entry_id'), function ($query) {
            $this->getArgument('entry_id')->addQuery($query, 'entry_id');
        });

        // Site ID
        $query->when($this->hasArgument('site'), function ($query) {
            $this->getArgument('site')->addQuery($query, 'site_id');
        });

        // URL Title
        $query->when($this->hasArgument('url_title'), function ($query) {
            $this->getArgument('url_title')->addQuery($query, 'url_title');
        });

        // Status
        $query->when($this->hasArgument('status'), function ($query) {
            $this->getArgument('status')->addQuery($query, 'status');
        });

        // Channel
        $query->when($this->hasArgument('channel'), function ($query) {
            $this->getArgument('channel')->addRelationshipQuery($query, 'channel', 'channel_name');
        });

        // Category
        $query->when($this->hasArgument('category'), function ($query) {
            $this->getArgument('category')->addRelationshipQuery($query, 'categories', 'cat_url_title');
        });

        // Category ID
        $query->when($this->hasArgument('category_id'), function ($query) {
            $this->getArgument('category_id')
                ->addRelationshipQuery($query, 'categories', (new Category)->qualifyColumn('cat_id'));
        });

        // Fixed Order
        $query->when($this->hasArgument('fixed_order'), function ($query) {
            $order = $this->getArgument('fixed_order');
            $query->whereIn('entry_id', $order);
            $query->orderByRaw('FIELD(entry_id, '.implode(',', $order).')');
        });

        // Start on
        $query->when($this->hasArgument('start_on'), function ($query) {
            $query->where('entry_date', '>=', $this->getArgument('start_on')->value);
        });

        // Stop before
        $query->when($this->hasArgument('stop_before'), function ($query) {
            $query->where('entry_date', '<', $this->getArgument('stop_before')->value);
        });

        // Dynamic
        if ($this->hasArgument('dynamic')) {
            // If we have live preview data we fill a model instance
            if (ee('LivePreview')->hasEntryData()) {
                return (new ChannelEntry)->newCollection([
                    (new ChannelEntry)->fillWithEntryData(ee('LivePreview')->getEntryData())->markAsPreview(),
                ]);
            }

            $lastSegment = last(ee()->uri->segment_array() ?: request()->segments());

            $this->setArgument('limit', 1);

            $query->when(is_numeric($lastSegment), function ($query) use ($lastSegment) {
                $query->where('entry_id', (int) $lastSegment);
            }, function ($query) use ($lastSegment) {
                $query->where('url_title', $lastSegment);
            });
        }

        // Search
        if ($this->hasArgument('search')) {
            foreach ($this->getArgument('search') as $field => $argument) {
                if ($this->fieldtypeManager->hasField($field)) {
                    $field = $this->fieldtypeManager->getField($field);
                    $alias = "search_{$field->field_name}";
                    $column = "$alias.field_id_{$field->field_id}";

                    $query->joinFieldDataTable($field, $alias);
                    $argument->addQuery($query, $column);
                } else {
                    $argument->addQuery($query, $field);
                }
            }
        }

        // Show Expired
        if ($this->getArgument('show_expired')->value) {
            $query->withoutGlobalScope(Scopes\HideExpired::class);
        }

        // Show Future
        if ($this->getArgument('show_future_entries')->value) {
            $query->withoutGlobalScope(Scopes\HideFuture::class);
        }

        // Orderby and Sort Direction
        if ($this->hasArgument('orderby')) {
            $directions = $this->hasArgument('sort') ? $this->getArgument('sort')->terms->map->value->toArray() : ['desc'];
            $fields = $this->getArgument('orderby');
            foreach ($fields->terms as $index => $field) {
                $direction = isset($directions[$index]) ? $directions[$index] : end($directions);
                $field = $field->value;
                if ($this->fieldtypeManager->hasField($field)) {
                    $query->orderByCustomField($field, $direction);
                } else {
                    $query->orderBy($query->qualifyColumn($field), $direction);
                }
            }
        }

        $data = $query->get();

        return $data;
    }

    public function getArgumentFallback($key, $value)
    {
        if (in_array($key, ['fixed_order'])) {
            return $value;
        }

        return new FilterArgument($value);
    }

    public function getStartOnArgument($value)
    {
        return \Carbon\Carbon::make($value)->timestamp;
    }

    public function getStopBeforeArgument($value)
    {
        return \Carbon\Carbon::make($value)->timestamp;
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
                'description' => 'Sets the display order of the entries',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => 'Include expired entries',
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'boolean',
                'description' => 'Include entries that have a date in the future',
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
                'description' => 'A particular date/time on which to stop the entries',
            ]),
            new Parameter([
                'name' => 'url_title',
                'type' => 'string',
                'description' => 'Limits the query by an entry’s url_title',
            ]),
            new Parameter([
                'name' => 'username',
                'type' => 'string',
                'description' => 'Limits the query by username',
            ]),
            new Parameter([
                'name' => 'search',
                'description' => 'Search for entries matching a certain criteria',
                'type' => function () {
                    return $this->fieldtypeManager->allFields()->map(function ($field) {
                        return new Parameter([
                            'name' => $field->field_name,
                            'type' => 'string',
                            'description' => $field->field_instructions,
                        ]);
                    })->merge([
                        new Parameter([
                            'name' => 'title',
                            'type' => 'string',
                            'description' => 'The title of an entry',
                        ]),
                    ])->toArray();
                },
            ]),
        ];
    }
}
