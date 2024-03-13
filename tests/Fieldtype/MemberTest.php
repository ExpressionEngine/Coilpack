<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class MemberTest extends TestCase
{
    public function test_member()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_members->value();

        $this->assertEquals('admin', $output->toArray()[0]['username']);
    }
}
