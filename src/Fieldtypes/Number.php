<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\TypedParameter as Parameter;

class Number extends Generic
{
    public function parameters(ChannelField $field = null)
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
