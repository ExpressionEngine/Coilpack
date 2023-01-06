<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Models\FieldContent;

class Radio extends OptionFieldtype
{
    public function apply(FieldContent $content, $parameters = [])
    {
        // Radio button does not support any parameters
        return parent::apply($content, []);
    }
}
