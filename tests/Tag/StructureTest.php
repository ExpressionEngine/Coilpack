<?php

namespace Tests\Tag;

use Tests\TestCase;

class StructureTest extends TestCase
{
    public function test_structure_breadcrumb()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $breadcrumb = $exp->structure->breadcrumb(['entry_id' => 4]);

        $this->assertStringContainsString('<a href="'.url('about-default-theme').'/">About Default Theme</a>', $breadcrumb);
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

        $nav = $exp->structure->nav(['start_from' => '/', 'status' => 'not Closed'])->render(function ($item, $children, $depth) {
            return implode('', [
                '<li>',
                '<a href="/'.$item['structure_url_title'].'/">'.$item['entry']['title'].'</a>',
                $children ? '<ul>'.$children.'</ul>' : '',
                '</li>',
            ]);
        });

        $this->assertStringContainsString('<a href="/about-default-theme/">About Default Theme</a>', $nav);
    }
}
