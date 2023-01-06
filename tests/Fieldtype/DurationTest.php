<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class DurationTest extends TestCase
{
    public function test_duration()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_duration->value();

        $this->assertEquals('1:01:00', (string) $output);
    }

    public function test_duration_with_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_duration->parameters(['format' => '%h hrs, %m min']);

        $this->assertEquals('1 hrs, 01 min', (string) $output);
    }
}
