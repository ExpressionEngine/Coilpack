<?php

namespace Expressionengine\Coilpack\View\Tags;

use Expressionengine\Coilpack\View\Tag;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;

class Channel extends Tag
{
    public function entries()
    {
        return ChannelEntry::query();
    }

}
