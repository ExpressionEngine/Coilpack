<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class KeyedValue extends GraphQLType
{
    protected $attributes = [
        'name' => 'KeyedValue',
        'description' => 'Key and value',
    ];

    public function fields(): array
    {
        return [
            'key' => [
                'type' => Type::string(),
                'description' => 'Key',
            ],
            'value' => [
                'type' => Type::string(),
                'description' => 'Value',
            ],
        ];
    }
}
