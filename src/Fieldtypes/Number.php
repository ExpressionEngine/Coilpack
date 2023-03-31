<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Support\Parameter;

class Number extends Generic
{
    public function parameters(Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'decimal_places',
                'type' => 'integer',
                'description' => 'The number of decimal digits to show after the number',
            ]),
        ];
    }
}
