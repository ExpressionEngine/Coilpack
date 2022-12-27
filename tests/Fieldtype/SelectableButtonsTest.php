<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class SelectableButtonsTest extends TestCase
{

    public function test_selectable_buttons()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_selectable_buttons->value();

        $this->assertEquals([
            'One'
        ], $output->toArray());
    }

    public function test_selectable_buttons_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_selectable_buttons->parameters(['limit' => 1, 'markup' => 'ul']);

        $this->assertEquals([
            'One',
        ], $output->toArray());

        $this->assertEquals('<ul><li>One</li></ul>', (string) $output);
    }
}
