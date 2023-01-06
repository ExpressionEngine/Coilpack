<?php

namespace Tests\Tag;

use Tests\TestCase;

class RequestTest extends TestCase
{
    public function test_get_variable()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $_GET['testing'] = 'testing_value';

        $testing = $exp->request->get->parameters(['name' => 'testing']);

        $this->assertEquals('testing_value', (string) $testing);

        unset($_GET['testing']);
    }

    public function test_post_variable()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $_POST['testing'] = 'testing_value';

        $testing = $exp->request->post->parameters(['name' => 'testing']);

        $this->assertEquals('testing_value', (string) $testing);

        unset($_POST['testing']);
    }
}
