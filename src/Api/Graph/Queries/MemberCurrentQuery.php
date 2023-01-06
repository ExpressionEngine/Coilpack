<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Models\Member\Member;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class MemberCurrentQuery extends Query
{
    protected $attributes = [
        'name' => 'me',
    ];

    public function type(): Type
    {
        return GraphQL::type('Member');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, $args)
    {
        $user = auth('coilpack')->user() ?: tap(new Member, function ($member) {
            $member->screen_name = 'Guest';
            $member->member_id = null;
        });

        return $user;
    }
}
