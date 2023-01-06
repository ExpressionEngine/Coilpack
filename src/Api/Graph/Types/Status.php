<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use Expressionengine\Coilpack\Models\Member\Member as StatusModel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Status extends GraphQLType
{
    protected $attributes = [
        'name' => 'Status',
        'description' => 'Collection of statuses',
        'model' => StatusModel::class,
    ];

    public function fields(): array
    {
        return [
            'member_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular entry',
            ],
            'screen_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
        ];
    }
}
