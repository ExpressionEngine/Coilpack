<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class FluidTest extends TestCase
{
    public function test_fluid()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_fluid->value();
        $this->assertEquals([
            'one',
            'two',
            '1664639700',
        ], array_map(function ($row) {
            return (string) $row->value();
        }, $output->toArray()));
    }
}
