<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use Expressionengine\Coilpack\Api\Graph\Fields;
use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Member\Member as MemberModel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Member extends GraphQLType
{
    protected $attributes = [
        'name' => 'Member',
        'description' => 'Collection of members',
        'model' => MemberModel::class,
    ];

    public function fields(): array
    {
        return array_merge([
            'member_id' => [
                'type' => Type::int(),
                'description' => 'Id of a particular member',
            ],
            'screen_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The members screen name',
            ],
        ], $this->customFields());
    }

    protected function customFields()
    {
        $fields = app(FieldtypeManager::class)->allFields('member');

        return $fields->flatMap(function ($field) {
            return [
                $field->m_field_name => new Fields\Fieldtype([
                    'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: Type::string(),
                    'field' => $field,
                    'selectable' => false,
                    'is_relation' => false,
                    'resolve' => function ($root, array $args) use ($field) {
                        return $root->{$field->m_field_name};
                    },
                ]),
            ];
        })->toArray();
    }
}
