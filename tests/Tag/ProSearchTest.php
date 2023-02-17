<?php

namespace Tests\Tag;

use Tests\TestCase;

class ProSearchTest extends TestCase
{
    public function test_single_variable()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $single = $exp->pro_variables->single(['var' => 'gv_comment_disabled']);
        $this->assertEquals('Commenting for this entry is <b>disabled</b>.', (string) $single);
    }
}
