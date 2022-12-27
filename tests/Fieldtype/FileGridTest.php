<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class FileGridTest extends TestCase
{

    public function test_file_grid()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file_grid->value();

        $this->assertEquals('blog', $output->toArray()[0]->file->filename);
        $this->assertEquals('Col Text', (string) $output->toArray()[0]->test_file_grid_col);

    }
}
