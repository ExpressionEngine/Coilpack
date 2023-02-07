<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\TypedParameter as Parameter;

class Duration extends Generic
{
    public function parameters(ChannelField $field = null)
    {
        return [
            new Parameter([
                'name' => 'format',
                'type' => 'string',
                'description' => 'Specify the format for this duration. Ex: %h hrs, %m min',
            ]),
        ];
    }
}
