<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class StructureTest extends TestCase
{
    public function test_structure()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_structure->value();
        $this->assertEquals(url('about-default-theme').'/', (string) $output);
    }
}
