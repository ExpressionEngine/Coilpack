<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ValueSliderTest extends TestCase
{
    public function test_value_slider()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_value_slider->value();

        $this->assertEquals('5', (string) $output);
    }
}
