<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class VariablesQuery extends Query
{
    protected $attributes = [
        'name' => 'variables',
    ];

    public function type(): Type
    {
        return GraphQL::type('Variables');
    }

    public function args(): array
    {
        return [
            'site' => [
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return (new \Expressionengine\Coilpack\View\Composers\GlobalComposer)->globals()['global'];
    }
}
