<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\Models\FieldContent;

abstract class Presenter
{
    abstract public function present(FieldContent $content, $arguments);
}
