<?php

namespace Expressionengine\Coilpack\View\Tags\Member;

use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;
use Expressionengine\Coilpack\View\Traits\CreatesHtmlForm;

class MemberSearch extends AddonTag
{
    use CreatesHtmlForm, InteractsWithAddon {
        CreatesHtmlForm::run as parentRun;
        CreatesHtmlForm::open as parentOpen;
    }

    protected $signature = 'member:member_search';

    public function run()
    {
        $this->setArgument('tagdata', '{!-- coilpack:fake --}');
        $this->setFormAttributes(parent::run()->toArray());

        return $this;
    }
}
