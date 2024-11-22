<?php

namespace Expressionengine\Coilpack\View\Tags\Member;

use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;
use Expressionengine\Coilpack\View\Traits\CreatesHtmlForm;

class EditAvatar extends AddonTag
{
    use CreatesHtmlForm, InteractsWithAddon {
        CreatesHtmlForm::run as parentRun;
        CreatesHtmlForm::open as parentOpen;
    }

    protected $signature = 'member:edit_avatar';

    public function run()
    {
        $this->setArgument('tagdata', '{!-- coilpack:fake --}');
        $this->setFormAttributes(parent::run()->toArray());

        return $this;
    }

    public function fields()
    {
        return collect($this->getFormAttribute('fields', []));
    }

}
