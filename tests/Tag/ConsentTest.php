<?php

namespace Tests\Tag;

use Tests\TestCase;

class ConsentTest extends TestCase
{
    // public function test_consent_form()
    // {
    //     $exp = app(\Expressionengine\Coilpack\View\Exp::class);

    //     $form = $exp->consent->form();
    // }

    // public function test_consent_alert()
    // {
    //     $exp = app(\Expressionengine\Coilpack\View\Exp::class);

    //     $alert = $exp->consent->alert();
    // }

    public function test_consent_requests()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $requests = $exp->consent->requests();

        $this->assertEquals([
            'ee:cookies_functionality',
            'ee:cookies_performance',
            'ee:cookies_targeting',
        ], $requests->pluck('consent_short_name')->toArray());
    }
}
