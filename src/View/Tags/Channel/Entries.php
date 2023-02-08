<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\TypedParameter as Parameter;
use Expressionengine\Coilpack\View\FilteredParameterValue;
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

    public function setAuthorIdArgument($author)
    {
        $author = new FilteredParameterValue($author);
        $author->filterQueryWithColumn($this->query, 'author_id');

        return $author;
    }

    public function setEntryIdArgument($id)
    {
        $id = new FilteredParameterValue($id);
        $id->filterQueryWithColumn($this->query, 'entry_id');

        return $id;
    }

    public function setUrlTitleArgument($title)
    {
        $title = new FilteredParameterValue($title);
        $title->filterQueryWithColumn($this->query, 'url_title');

        return $title;
    }

    public function setStatusArgument($status)
    {
        $status = new FilteredParameterValue($status);
        $status->filterQueryWithColumn($this->query, 'status');

        return $status;
    }

    public function setChannelArgument($channel)
    {
        $channel = new FilteredParameterValue($channel);

        $this->whereHas('channel', function ($query) use ($channel) {
            return $channel->filterQueryWithColumn($query, 'channel_name');
        });

        return $channel;
    }

    public function setCategoryArgument($category)
    {
        $category = new FilteredParameterValue($category);

        $this->whereHas('categories', function ($query) use ($category) {
            return $category->filterQueryWithColumn($query, 'cat_url_title');
        });

        return $category;
    }

    public function setCategoryIdArgument($category)
    {
        $category = new FilteredParameterValue($category);

        $this->whereHas('categories', function ($query) use ($category) {
            return $category->filterQueryWithColumn($query, 'cat_id');
        });

        return $category;
    }

    public function setDynamicArgument()
    {
        $lastSegment = last(request()->segments());

        $this->setLimitArgument(1);

        $this->when(is_int($lastSegment), function ($query) use ($lastSegment) {
            $query->where('entry_id', (int) $lastSegment);
        }, function ($query) use ($lastSegment) {
            $query->where('url_title', $lastSegment);
        });

        return true;
    }

    public function setFixedOrderArgument($order = [])
    {
        $this->query->whereIn('entry_id', $order);
        $this->query->orderByRaw('FIELD(entry_id, '.implode(',', $order).')');

        return $order;
    }

    public function setLimitArgument($count)
    {
        $this->query->take($count);

        if ($count == 1) {
            $this->takeFirst = true;
        }

        return $count;
    }

    public function setDisableArgument($str)
    {
    }

    public function toGraphQL(): array
    {
        return [
            'type' => Type::listOf(GraphQL::type('ChannelEntry')),
        ];
    }
}
