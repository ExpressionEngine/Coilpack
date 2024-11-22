<?php

namespace Expressionengine\Coilpack\View\Tags\Channel;

use Expressionengine\Coilpack\Traits\InteractsWithAddon;
use Expressionengine\Coilpack\View\AddonTag;
use Expressionengine\Coilpack\View\Traits\CreatesHtmlForm;

class Form extends AddonTag
{
    use CreatesHtmlForm, InteractsWithAddon {
        CreatesHtmlForm::run as parentRun;
        CreatesHtmlForm::open as parentOpen;
    }

    protected $signature = 'channel:form';

    public function run()
    {
        $this->setFormAttributes(parent::run()->toArray());

        if (strpos($this->getFormAttribute('open'), '</form>') !== false) {
            $open = $this->getFormAttribute('open');
            $position = strpos($this->getFormAttribute('open'), '</form>');
            $this->setFormAttribute('open', substr($open, 0, $position));
            $this->setFormAttribute('close', substr($open, $position));
        }

        return $this;
    }

    public function fields()
    {
        return collect($this->getFormAttribute('fields', []));
    }
}
