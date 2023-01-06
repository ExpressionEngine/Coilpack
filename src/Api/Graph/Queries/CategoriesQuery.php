<?php

namespace Expressionengine\Coilpack\Api\Graph\Queries;

use Expressionengine\Coilpack\Models\Category\Category;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class CategoriesQuery extends Query
{
    protected $attributes = [
        'name' => 'categories',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Category'));
    }

    public function args(): array
    {
        return [
            'channel' => [
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
        $with = array_merge(['data', 'group'], $fields->getRelations());

        $categories = Category::select($select)->with($with);

        // Filter by Channel name
        $categories->when($args['channel'] ?? false, function ($query) use ($args) {
            $query->whereHas('channel', function ($query) use ($args) {
                $query->where('channel_name', $args['channel']);
            });
        });

        // Filter by status
        $categories->when($args['status'] ?? false, function ($query) use ($args) {
            $query->where('status', $args['status']);
        });

        $categories->when($args['limit'] ?? false, function ($query) use ($args) {
            $query->take($args['limit']);
        });

        return $categories->get();
    }
}
