<?php

namespace Expressionengine\Coilpack\Controllers;

class AdminController
{
    public function __invoke()
    {
        return (new \Expressionengine\Coilpack\Bootstrap\LoadExpressionEngine)
            ->admin()
            ->bootstrap(app())
            ->runGlobal();
    }
}
