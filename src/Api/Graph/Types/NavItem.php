<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NavItem extends GraphQLType
{
    protected $attributes = [
        'name' => 'NavItem',
        'description' => 'Collection of Structure navigation items',
    ];

    public function fields(): array
    {
        return [
            'entry' => [
                'type' => GraphQL::type('ChannelEntry'),
            ],
            'children' => [
                'type' => Type::listOf(GraphQL::type('NavItem')),
            ],
            'depth' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'structure_url_title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'slug' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'hidden' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
        ];
    }
}
