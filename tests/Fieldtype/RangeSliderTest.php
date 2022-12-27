<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class RangeSliderTest extends TestCase
{

    public function test_range_slider()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_range_slider->value();

        $this->assertEquals([
            'from' => 5,
            'to' => 10
        ], $output->toArray());

        $this->assertEquals('5 &mdash; 10', (string) $output);
    }

    public function test_range_slider_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_range_slider->parameters([
            'decimal_place'  => '2',
            'prefix'  => 'yes',
            'suffix'  => 'yes',
        ]);

        $this->assertEquals([
            'from' => 5,
            'to' => 10
        ], $output->toArray());

        $this->assertEquals('5.00 &mdash; 10.00', (string) $output);
    }
}
