<?php

namespace Tests\Tag\Channel;

use Tests\TestCase;

class EntriesTest extends TestCase
{
    private $channel;

    public function setUp(): void
    {
        parent::setUp();

        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $this->channel = $exp->channel;
    }

    public function test_channel_entries_channel()
    {
        $entries = $this->channel->entries(['channel' => 'Testing']);
        $this->assertEquals(1, $entries->count());

        // Alternate syntax
        $entries = $this->channel->entries->arguments(['channel' => 'Testing'])->run();
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_not_channel()
    {
        $entries = $this->channel->entries(['channel' => 'not Testing']);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_status()
    {
        $entries = $this->channel->entries(['status' => 'open']);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_not_status()
    {
        $entries = $this->channel->entries(['status' => 'not open']);
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_category()
    {
        $entries = $this->channel->entries(['category' => 'news']);
        $this->assertEquals(1, $entries->count());
    }

    public function test_channel_entries_not_category()
    {
        $entries = $this->channel->entries(['category' => 'not news']);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_orderby()
    {
        $id = 0;

        $this->channel->entries([
            'orderby' => 'entry_id',
            'sort' => 'asc',
            'sticky' => 'no',
        ])->each(function ($entry) use (&$id) {
            $this->assertTrue($entry->entry_id > $id);
            $id = $entry->entry_id;
        });
    }

    public function test_channel_entries_search()
    {
        $entries = $this->channel->entries([
            'search' => [
                'seo_title' => 'IS_EMPTY',
            ],
        ]);
        $this->assertEquals(1, $entries->count());

        $entries = $this->channel->entries([
            'search' => [
                'seo_title' => 'blog|cover',
            ],
        ]);
        $this->assertEquals(2, $entries->count());

        $entries = $this->channel->entries([
            'search' => [
                'seo_title' => 'not IS_EMPTY',
            ],
        ]);
        $this->assertEquals(12, $entries->count());
    }

    public function test_channel_entries_pagination()
    {
        $entries = $this->channel->entries([
            'per_page' => 2,
        ]);

        $this->assertEquals(2, $entries->count());
    }
}
