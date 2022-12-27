<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class EmailTest extends TestCase
{

    public function test_email()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_email->value();
        $this->assertEquals('test@example.com', (string) $output);
    }

    public function test_email_mailto_modifier()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_email->mailto(['title' => 'Test', 'subject' => 'Testing', 'encode' => false]);
        $this->assertEquals('<a href="mailto:test@example.com?subject=Testing">Test</a>', (string) $output);
    }

}
