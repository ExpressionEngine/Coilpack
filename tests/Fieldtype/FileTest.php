<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class FileTest extends TestCase
{

    public function test_file()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->value();
        $this->assertEquals('blog', $output->filename);
    }

    public function test_file_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->parameters(['wrap' => 'link']);
        $this->assertEquals('<a href="http://laravel.test/themes/user/site/default/asset/img/blog/blog.jpg">blog</a>', (string) $output);
    }

    public function test_file_rotate()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->rotate(['angle' => 90]);

        $this->assertStringContainsString('_rotate', (string) $output);
    }

    public function test_file_crop()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->crop(['width' => 100, 'height' => 100]);

        $this->assertStringContainsString('_crop', (string) $output);
    }

    public function test_file_resize()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->resize(['width' => 100, 'height' => 100]);

        $this->assertStringContainsString('_resize', (string) $output);
    }

    public function test_file_webp()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->webp(['width' => 100, 'height' => 100]);

        $this->assertStringContainsString('_webp', (string) $output);
    }

    public function test_file_resize_crop()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_file->resize_crop(['resize:width' => 300, 'crop:width' => 100]);

        $this->assertStringContainsString('_crop', (string) $output);
    }
}
