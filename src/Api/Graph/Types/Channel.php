<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use Expressionengine\Coilpack\Api\Graph\Fields\FormattableDate;
use Expressionengine\Coilpack\Models\Channel\Channel as ChannelModel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Channel extends GraphQLType
{
    protected $attributes = [
        'name' => 'Channel',
        'description' => 'Collection of channels',
        'model' => ChannelModel::class
    ];


    public function fields(): array
    {
        return [
            'channel_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular entry',
            ],
            'site_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular entry',
            ],
            'channel_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
            'channel_title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
            'channel_url' => [
                'type' => Type::string(),
                'description' => 'The members screen name',
            ],
            'channel_description' => [
                'type' => Type::string(),
                'description' => 'The members screen name',
            ],
        ];
    }
}
