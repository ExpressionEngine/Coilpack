<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class ChannelEntriesQuery extends Query
{
    protected $attributes = [
        'name' => 'channel_entries',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('ChannelEntry'));
    }

    public function args(): array
    {
        return [
            'channel' => [
                'type' => Type::string(),
            ],
            'title' => [
                'type' => Type::string(),
            ],
            'status' => [
                'type' => Type::string(),
            ],
            'limit' => [
                'type' => Type::int(),
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, \Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = array_merge(['data', 'channel'], $fields->getRelations());

        $entries = ChannelEntry::select($select)->with($with);

        // Filter by Channel Name
        $entries->when($args['channel'] ?? false, function ($query) use ($args) {
            $query->whereHas('channel', function ($query) use ($args) {
                $query->where('channel_name', $args['channel']);
            });
        });

        // Filter by Entry Title
        $entries->when($args['title'] ?? false, function ($query) use ($args) {
            $query->where('title', $args['title']);
        });

        // Filter by Status
        $entries->when($args['status'] ?? false, function ($query) use ($args) {
            $query->where('status', $args['status']);
        });

        $entries->when($args['limit'] ?? false, function ($query) use ($args) {
            $query->take($args['limit']);
        });

        return $entries->get();
    }
}
