<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Category\Category;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Models\Channel\Scopes;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\Support\Arguments\ListArgument;
use Expressionengine\Coilpack\Support\Arguments\SearchArgument;
use Expressionengine\Coilpack\Support\Arguments\Term;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\View\ModelTag;

class Entries extends ModelTag implements ConvertsToGraphQL
{
    protected $fieldtypeManager;

    public function __construct()
    {
        $this->query = ChannelEntry::query();
        $this->fieldtypeManager = app(FieldtypeManager::class);
    }

    public function defineParameters(): array
    {
        return array_merge(parent::defineParameters(), [
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
                'name' => 'orderby',
                'type' => 'string',
                'description' => 'Order the entries by a field',
                'defaultValue' => 'entry_date',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => 'Include entries with an expiration date that has passed',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'boolean',
                'description' => 'Include entries with an entry_date in the future',
                'defaultValue' => false,
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'The sort order (asc/desc)',
                'defaultValue' => 'desc',
            ]),
            new Parameter([
                'name' => 'sticky',
                'type' => 'string',
                'description' => 'Handle "sticky" entries',
                'defaultValue' => 'yes',
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
                'name' => 'year',
                'type' => 'integer',
                'description' => 'Limits the query by year',
            ]),
            new Parameter([
                'name' => 'month',
                'type' => 'integer',
                'description' => 'Limits the query by month',
            ]),
            new Parameter([
                'name' => 'day',
                'type' => 'integer',
                'description' => 'Limits the query by day',
            ]),
            new Parameter([
                'name' => 'search',
                // 'prefix' => 'Channel_Entries',
                'description' => 'Search for entries matching a certain criteria',
                'type' => function () {
                    return app(FieldtypeManager::class)->allFields()->toBase()->map(function ($field) {
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
        ]);
    }

    public function getArgumentFallback($key, $value)
    {
        if (in_array($key, ['fixed_order', 'sticky'])) {
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

    public function getWithArgument($value)
    {
        // If the 'data' relation is requested we will append 'channel' and 'hiddenFields'
        // because these are necessary for properly displaying custom field data
        if (in_array('data', explode('|', $value))) {
            $value .= '|channel|hiddenFields';
        }

        return parent::getWithArgument($value);
    }

    public function run()
    {
        // Author
        $this->query->when($this->hasArgument('author'), function ($query) {
            $this->getArgument('author')->addQuery($query, 'author_id');
        });

        // Entry ID
        $this->query->when($this->hasArgument('entry_id'), function ($query) {
            $this->getArgument('entry_id')->addQuery($query, (new ChannelEntry)->qualifyColumn('entry_id'));
        });

        // Site ID
        $this->query->when($this->hasArgument('site'), function ($query) {
            $this->getArgument('site')->addQuery($query, 'site_id');
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
            $this->getArgument('channel')->addRelationshipQuery($query, 'channel', 'channel_name');
        });

        // Category
        $this->query->when($this->hasArgument('category'), function ($query) {
            $this->getArgument('category')->addRelationshipQuery($query, 'categories', 'cat_url_title');
        });

        // Category ID
        $this->query->when($this->hasArgument('category_id'), function ($query) {
            $this->getArgument('category_id')
                ->addRelationshipQuery($query, 'categories', (new Category)->qualifyColumn('cat_id'));
        });

        // Fixed Order
        $this->query->when($this->hasArgument('fixed_order'), function ($query) {
            $order = $this->getArgument('fixed_order');
            $query->whereIn('entry_id', $order);
            $query->orderByRaw('FIELD(entry_id, '.implode(',', $order).')');
        });

        // Start on
        $this->query->when($this->hasArgument('start_on'), function ($query) {
            $query->where('entry_date', '>=', $this->getArgument('start_on')->value);
        });

        // Stop before
        $this->query->when($this->hasArgument('stop_before'), function ($query) {
            $query->where('entry_date', '<', $this->getArgument('stop_before')->value);
        });

        // Year/Month/Day
        $this->query->when($this->hasAnyArgument('year', 'month', 'day'), function ($query) {
            $year = $this->getArgument('year')->value ?: date('Y');
            $start = [
                'month' => $this->hasArgument('month') ? $this->getArgument('month')->value : 1,
                'day' => $this->hasArgument('day') ? $this->getArgument('day')->value : 1
            ];
            $end = [
                'month' => $this->hasArgument('month') ? $this->getArgument('month')->value : 12,
                'day' => $this->hasArgument('day') ? $this->getArgument('day')->value : null
            ];
            if(is_null($end['day'])) {
                ee()->load->helper('date');
                $end['day'] = \days_in_month($end['month'], $year);
            }
            $query->whereBetween('entry_date', [
                ee()->localize->string_to_timestamp("{$year}-{$start['month']}-{$start['day']} 00:00"),
                ee()->localize->string_to_timestamp("{$year}-{$end['month']}-{$end['day']} 23:59")
            ]);
        });

        // Dynamic
        if ($this->hasArgument('dynamic')) {
            // If we have live preview data we fill a model instance
            if (ee('LivePreview')->hasEntryData()) {
                return (new ChannelEntry)->newCollection([
                    (new ChannelEntry)->fillWithEntryData(ee('LivePreview')->getEntryData())->markAsPreview(),
                ]);
            }

            // EE sets the page_query_string to an entry_id if the segment is found
            // in the config site_pages array during Core::generate_page()
            $lastSegment = last(ee()->uri->segment_array() ?: request()->segments());
            $queryString = (ee()->uri->page_query_string != '') ? ee()->uri->page_query_string : $lastSegment;
            $this->setArgument('limit', 1);

            $this->query->when(is_numeric($queryString), function ($query) use ($queryString) {
                $query->where('entry_id', (int) $queryString);
            }, function ($query) use ($queryString) {
                $query->where('url_title', $queryString);
            });
        }

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

        // Show Expired
        if ($this->getArgument('show_expired')->value) {
            $this->query->withoutGlobalScope(Scopes\HideExpired::class);
        }

        // Show Future
        if ($this->getArgument('show_future_entries')->value) {
            $this->query->withoutGlobalScope(Scopes\HideFuture::class);
        }

        // Sticky
        if (! $this->hasArgument('sticky') || $this->getArgument('sticky')->value == 'yes') {
            $this->setArgument('orderby', 'sticky|'.($this->arguments['orderby'] ?? ''));
            $this->setArgument('sort', 'desc|'.($this->arguments['sort'] ?? ''));
        }

        if ($this->hasArgument('sticky')) {
            if ($this->getArgument('sticky')->value == 'only') {
                $this->query->where('sticky', 'y');
            }

            if ($this->getArgument('sticky')->value == 'none') {
                $this->query->where('sticky', 'n');
            }
        }

        // Orderby and Sort Direction
        $directions = $this->getArgument('sort')->terms->map->value->toArray();
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

        // Add page data to channel entries after the query
        $site_pages = config_item('site_pages');

        $this->getArgument('site')->terms->each(function ($term) use (&$site_pages) {
            if ($term->value && $term->value != ee()->config->item('site_id')) {
                $pages = ee()->config->site_pages($term->value);
                $site_pages[$term->value] = $pages[$term->value];
            }
        });

        return tap(parent::run(), function ($result) use ($site_pages) {
            // If we have live preview data we fill a model instance
            $previewEntry = new ChannelEntry;

            if (ee('LivePreview')->hasEntryData()) {
                $previewEntry->fillWithEntryData(ee('LivePreview')->getEntryData())->markAsPreview();
            }

            $result->transform(function ($entry) use ($site_pages, $previewEntry) {
                if ($entry->entry_id == $previewEntry->entry_id) {
                    $entry = $previewEntry;
                }

                $entry->page_uri = '';
                $entry->page_url = '';

                if ($site_pages !== false && isset($site_pages[$entry->site_id]['uris'][$entry->entry_id])) {
                    $entry->page_uri = $site_pages[$entry->site_id]['uris'][$entry->entry_id];
                    $entry->page_url = ee()->functions->create_page_url($site_pages[$entry->site_id]['url'], $entry->page_uri);
                }

                return $entry;
            });
        });
    }

    public function toGraphQL(): array
    {
        return [
            'type' => GraphQL::paginate('ChannelEntry'),
            'middleware' => [
                \Expressionengine\Coilpack\Api\Graph\Middleware\ResolvePage::class,
            ],
        ];
    }
}
