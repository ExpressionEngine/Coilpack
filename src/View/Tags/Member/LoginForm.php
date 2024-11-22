<?php

namespace Expressionengine\Coilpack\View\Tags\Member;

use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;
use Expressionengine\Coilpack\View\Traits\CreatesHtmlForm;

class LoginForm extends AddonTag
{
    use CreatesHtmlForm, InteractsWithAddon {
        CreatesHtmlForm::run as parentRun;
        CreatesHtmlForm::open as parentOpen;
    }

    protected $signature = 'member:login_form';

    public function run()
    {
        $this->setFormAttributes(parent::run()->toArray());

        return $this;
    }
}
