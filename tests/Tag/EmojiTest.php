<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class EmojiTest extends TestCase
{

    public function test_emoji_list()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $emojis = $exp->emoji->emoji_list();

    }
}
