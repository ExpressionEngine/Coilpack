<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ProSearchTest extends TestCase
{

    public function test_single_variable()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $single = $exp->pro_variables->single->var('gv_comment_disabled')->process();
        // dd($single);
    }
}
