<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class StructureTest extends TestCase
{

    public function test_structure_breadcrumb()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $breadcrumb = $exp->structure->breadcrumb(['entry_id' => 4]);

        $this->assertStringContainsString('<a href="http://laravel.test/about-default-theme/">About Default Theme</a>', $breadcrumb);
    }

    public function test_structure_entries()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);
        $entries = $exp->structure->entries(['parent_id' => 2]);

        $this->assertEquals(3, $entries->first()->entry_id);
        $this->assertEquals(4, $entries->last()->entry_id);
    }

    public function test_structure_nav()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        // $nav = $exp->structure->entries->parent_id(2);
        // $nav = $exp->structure->nav->start_from('/');
        $nav = $exp->structure->nav(['start_from' => '/', 'status' => 'not Closed']);

        $this->assertStringContainsString('<a href="/about-default-theme/">About Default Theme</a>', $nav);
    }
}
