<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class TextInputTest extends TestCase
{

    public function test_text_input()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_text_input->value();
        $this->assertEquals('text input', (string) $output);
    }

}
