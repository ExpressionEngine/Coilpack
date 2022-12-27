<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class CommentTest extends TestCase
{

    public function test_comment_entries()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $comments = $exp->comment->entries(['channel' => 'blog', 'url_title' => 'action-comedy-how-to']);
        $this->assertEquals(11, $comments->count());
    }

}
