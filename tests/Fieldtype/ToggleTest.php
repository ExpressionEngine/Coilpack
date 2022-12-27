<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ToggleTest extends TestCase
{

    public function test_toggle()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_toggle->value();

        $this->assertEquals('1', (string) $output);
    }

}
