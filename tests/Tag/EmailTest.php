<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class EmailTest extends TestCase
{

    public function test_contact_form()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        // $form = $exp->email->contact_form->process();
        // dd($form);
    }
}
