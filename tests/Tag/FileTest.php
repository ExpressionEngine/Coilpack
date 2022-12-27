<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * https://docs.expressionengine.com/latest/add-ons/file.html#file-entries-tag
     * @return void
     */
    public function test_file_entries()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->file->entries(['directory_id' => 6, 'limit' => 5, 'category' => 'not 25']);

        $this->assertEquals([
            'path.jpg',
            'sky.jpg',
            'lake.jpg',
            'ocean.jpg',
        ], $entries->pluck('filename')->toArray());
    }
}
