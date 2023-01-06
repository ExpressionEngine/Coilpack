<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class MultiSelectTest extends TestCase
{
    public function test_multi_select()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_multi_select->value();

        $this->assertEquals([
            'one',
        ], $output->toArray());

        $this->assertEquals('one', (string) $output);
    }

    public function test_multi_select_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_multi_select->parameters(['limit' => 1, 'markup' => 'ul']);

        $this->assertEquals([
            'one',
        ], $output->toArray());

        $this->assertEquals('<ul><li>one</li></ul>', (string) $output);
    }
}
