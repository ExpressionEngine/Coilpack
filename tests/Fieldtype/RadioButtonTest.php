<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class RadioButtonTest extends TestCase
{
    public function test_radio_button()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_radio_buttons->value();

        $this->assertEquals('One', (string) $output);
    }
}
