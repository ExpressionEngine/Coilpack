<?php

namespace Tests\Tag;

use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function test_channel_entries_channel()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['channel' => 'Testing']);
        $this->assertEquals(1, $entries->count());

        // Alternate syntax
        $entries = $exp->channel->entries->parameters(['channel' => 'Testing'])->get();
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_not_channel()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['channel' => 'not Testing']);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_status()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['status' => 'open']);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_not_status()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['status' => 'not open']);
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_category()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['category' => 'news']);
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_not_category()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->channel->entries(['category' => 'not news']);
        $this->assertEquals(6, $entries->count());
    }

    public function test_prev_next_entry()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        // dd(get_class($exp->channel));
        $previous = $exp->channel->prev_entry(['channel' => 'blog', 'url_title' => 'action-comedy-how-to']);
        $this->assertEquals('marrow-and-the-broken-bones', $previous->url_title);

        ee()->session->cache = [];

        $next = $exp->channel->next_entry(['channel' => 'blog', 'url_title' => 'marrow-and-the-broken-bones']);
        $this->assertEquals('action-comedy-how-to', $next->url_title);
    }

    public function test_categories()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $categories = $exp->channel->categories(['channel' => 'blog', 'style' => 'linear']);
        $this->assertEquals([
            'News',
            'Personal',
            'Photos',
            'Videos',
            'Music',
        ], $categories->pluck('category_name')->toArray());
    }

    public function test_category_heading()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $heading = $exp->channel->category_heading(['category_id' => 1]);
        $this->assertEquals('News', $heading->category_name);
    }

    public function test_category_archive()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $categories = $exp->channel->category_archive(['channel' => 'blog', 'style' => 'nested']);
        // dd($categories);
    }

    public function test_info()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $info = $exp->channel->info(['channel' => 'blog']);
        // dd($info);
    }
}
