<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class UrlTest extends TestCase
{
    public function test_url()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_url->value();

        $this->assertEquals('http://test.com', (string) $output);
    }
}
