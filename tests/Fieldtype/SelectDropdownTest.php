<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class SelectDropdownTest extends TestCase
{

    public function test_select_dropdown()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_select_dropdown->value();
        $this->assertEquals('One', (string) $output);
    }

    public function test_select_dropdown_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_select_dropdown->parameters(['limit' => 1, 'markup' => 'ul']);

        $this->assertEquals([
            'One',
        ], $output->toArray());

        $this->assertEquals('<ul><li>One</li></ul>', (string) $output);
    }
}
