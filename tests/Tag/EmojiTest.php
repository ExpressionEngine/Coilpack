<?php

namespace Tests\Tag;

use Tests\TestCase;

class EmojiTest extends TestCase
{
    public function test_emoji_list()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $emojis = $exp->emoji->emoji_list();
    }
}
