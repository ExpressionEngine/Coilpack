<?php

namespace Expressionengine\Coilpack\Api\Graph\Support;


use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class GeneratedType extends GraphQLType
{
    // protected $attributes = [
    //     'name' => 'Grid',
    //     'description' => 'Collection of channel entries',
    // ];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }


    public function fields(): array
    {
        if(is_callable($this->attributes['fields'])) {
            return $this->attributes['fields']();
        }

        return $this->attributes['fields'] ?? [];
    }
}
