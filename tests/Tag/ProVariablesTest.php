<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ProVariablesTest extends TestCase
{

    public function test_variable_single()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $single = $exp->pro_variables->single(['var' => 'gv_comment_disabled']);
        $this->assertEquals('Commenting for this entry is <b>disabled</b>.', $single);
    }

    public function test_variable_single_all()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $singles = $exp->pro_variables->single();
        $this->assertEquals('There are <b>no</b> comments on this entry.', $singles->gv_comment_none);
    }

    public function test_variable_label()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $label = $exp->pro_variables->label(['var' => 'gv_comment_disabled']);
        $this->assertEquals('', $label);
    }



}
