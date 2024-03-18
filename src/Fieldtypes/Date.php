<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Support\Parameter;

class Date extends Generic
{
    public function parametersForField(?Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'format',
                'type' => 'string',
                'description' => 'Specify the format for this date',
            ]),
        ];
    }
}
