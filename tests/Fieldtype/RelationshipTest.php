<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class RelationshipTest extends TestCase
{

    public function test_relationship()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_relationships->value();
        $this->assertEquals('Entry with SoundCloud audio', $output->toArray()[0]['title']);
    }

}
