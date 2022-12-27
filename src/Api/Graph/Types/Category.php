<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use Expressionengine\Coilpack\Api\Graph\Fields\FormattableDate;
use Expressionengine\Coilpack\Models\Category\Category as CategoryModel;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Category extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'Collection of categories',
        'model' => CategoryModel::class
    ];


    public function fields(): array
    {
        return array_merge([
            'cat_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular category',
            ],
            'cat_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
            'cat_url_title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
            'cat_description' => [
                'type' => Type::string(),
                'description' => 'The members screen name',
            ],
            'cat_image' => [
                'type' => Type::string(),
                'description' => 'The members screen name',
            ],
         ], $this->customFields());
    }

    protected function customFields()
    {
        $fields = app(FieldtypeManager::class)->allFields('category');

        return $fields->flatMap(function($field) {
            return [
                $field->field_name => [
                    'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: \GraphQL\Type\Definition\Type::string(),
                    // 'type' => $field->field_type == 'grid' ? Type::listOf(GraphQL::type("Field\\$field->field_name")) : Type::string(),
                    'selectable' => false,
                    'is_relation' => false,
                    'resolve' => function ($root, array $args) use($field) {
                        return $root->{$field->field_name} ?? null;
                    }
                ]
            ];
        })->toArray();
    }
}
