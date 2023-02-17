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
            'One',
            'Two',
            '1664639700',
            '<p>Test <strong>rich text</strong></p>',
            '',
            'Textarea',
        ], array_map(function ($row) {
            return (string) $row->value();
        }, $output->toArray()));
    }
}
