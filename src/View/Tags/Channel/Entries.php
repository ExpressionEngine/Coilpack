<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\View\FilteredParameterValue;
use Expressionengine\Coilpack\View\ModelTag;

class Entries extends ModelTag
{
    public function __construct()
    {
        $this->query = ChannelEntry::query();
    }

    public function setAuthorIdArgument($author)
    {
        $author = new FilteredParameterValue($author);
        $author->filterQueryWithColumn($this->query, 'author_id');

        return $author;
    }

    public function setChannelArgument($channel)
    {
        $channel = new FilteredParameterValue($channel);

        $this->whereHas('channel', function ($query) use ($channel) {
            return $channel->filterQueryWithColumn($query, 'channel_name');
        });

        return $channel;
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
}
