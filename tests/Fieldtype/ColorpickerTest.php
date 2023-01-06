<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ColorpickerTest extends TestCase
{
    public function test_colorpicker()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_colorpicker->value();
        $this->assertEquals('#FF0000', (string) $output);
    }

    public function test_colorpicker_modifiers()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_colorpicker->contrast_color();
        $this->assertEquals('#ffffff', (string) $output);
    }
}
