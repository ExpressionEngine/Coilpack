<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Models\Member\Member;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
