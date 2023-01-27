<?php

namespace Expressionengine\Coilpack\Api\Graph;

use Expressionengine\Coilpack\Facades\GraphQL;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class Schema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => GraphQL::getQueries(),
            'mutation' => [

            ],
            'middleware' => GraphQL::getMiddleware(),
            'method' => ['GET', 'POST'],
            'types' => GraphQL::getTypes(),
        ];
    }
}
