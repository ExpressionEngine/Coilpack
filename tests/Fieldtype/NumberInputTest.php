<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class NumberInputTest extends TestCase
{

    public function test_number_input()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_number_input->value();
        $this->assertEquals(123, (string) $output);
    }

    public function test_number_input_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_number_input->parameters(['decimal_places' => 2]);
        $this->assertEquals(123.00, (string) $output);
    }

}
