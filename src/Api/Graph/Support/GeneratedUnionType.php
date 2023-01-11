<?php

namespace Expressionengine\Coilpack\Api\Graph\Support;

use Rebing\GraphQL\Support\UnionType as GraphQLType;

class GeneratedUnionType extends GraphQLType
{
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function types(): array
    {
        if (is_callable($this->attributes['types'])) {
            return $this->attributes['types']();
        }

        return $this->attributes['types'] ?? [];
    }
}
