<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ChannelEntryQuery extends Query
{
    protected $attributes = [
        'name' => 'channel_entry',
    ];

    public function type(): Type
    {
        return GraphQL::type('ChannelEntry');
    }

    public function args(): array
    {
        return [
            'entry_id' => [
                'name' => 'entry_id',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return ChannelEntry::findOrFail($args['entry_id']);
    }
}
