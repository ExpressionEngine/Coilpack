<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class MembersQuery extends Query
{
    protected $attributes = [
        'name' => 'members',
    ];

    public function type(): Type
    {
        return GraphQL::type('Member');
    }

    public function args(): array
    {
        return [];
    }
}
