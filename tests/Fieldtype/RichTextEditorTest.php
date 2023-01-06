<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class RichTextEditorTest extends TestCase
{
    public function test_rich_text_editor()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_rich_text_editor->value();
        $this->assertEquals('<p>Test <strong>strong</strong></p>', (string) $output);
    }

    public function test_rich_text_editor_modifiers()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_rich_text_editor->excerpt();
        $this->assertEquals('<p>Test <strong>strong</strong></p>', (string) $output);
    }
}
