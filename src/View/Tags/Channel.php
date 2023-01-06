<?php

namespace Expressionengine\Coilpack\View\Tags;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\View\Tag;

class Channel extends Tag
{
    public function entries()
    {
        return ChannelEntry::query();
    }
}
