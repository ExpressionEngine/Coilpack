<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class DateTest extends TestCase
{

    public function test_date()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_date->value();

        $this->assertEquals(1667231340, (string) $output);
    }

    public function test_date_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_date->parameters(['format' => '%m/%d/%Y', 'timezone' => 'UTC']);

        $this->assertEquals('10/31/2022', (string) $output);
    }
}
