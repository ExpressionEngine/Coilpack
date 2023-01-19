<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class CheckboxesTest extends TestCase
{
    public function test_checkboxes()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_checkboxes->value();

        $this->assertEquals(['One', 'Three'], $output->toArray());
        $this->assertEquals('One, Three', (string) $output);

        $this->assertEquals(['One', 'Two', 'Three'], array_values($output->options));
        $this->assertEquals(['one', 'two', 'three'], array_keys($output->options));
    }

    public function test_checkboxes_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_checkboxes->parameters(['limit' => 1, 'markup' => 'ul']);

        $this->assertEquals([
            'One',
        ], $output->toArray());

        $this->assertEquals('<ul><li>One</li></ul>', (string) $output);
    }
}
