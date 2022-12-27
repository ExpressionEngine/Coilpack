<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

// use Expressionengine\Coilpack\Api\Graph\Fields\FormattableDate;
use Expressionengine\Coilpack\Api\Graph\Fields;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry as ChannelEntryModel;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ChannelEntry extends GraphQLType
{
    protected $attributes = [
        'name' => 'ChannelEntry',
        'description' => 'Collection of channel entries',
        'model' => ChannelEntryModel::class
    ];


    public function fields(): array
    {
        return array_merge([
            'entry_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular entry',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the entry',
            ],
            'site_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a site',
            ],
            'channel_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a channel',
            ],
            'channel' => [
                'type' => Type::nonNull(GraphQL::type('Channel')),
                'description' => 'Id of a channel',
            ],
            'author_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a author',
            ],
            'author' => [
                'type' => Type::nonNull(GraphQL::type('Member')),
                'description' => 'Id of a author',
            ],
            'status_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a status',
            ],
            'status' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Id of a site',
            ],
            'entry_date' => new Fields\FormattableDate,
            'year' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Year of the entry',
            ],
            'month' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Month of the entry',
            ],
            'day' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Day of the entry',
            ],
            'edit_date' => new Fields\FormattableDate,
            'expiration_date' => new Fields\FormattableDate,
            'comment_expiration_date' => new Fields\FormattableDate,
            'recent_comment_date' => new Fields\FormattableDate,
            'comment_total' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Number of comments',
            ],
            'allow_comments' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Are comments allowed',
            ],
            'sticky' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Is the entry sticky',
            ],
            'categories' => [
                'type' => Type::listOf(GraphQL::type('Category')),
                'description' => 'The entry categories',
            ],
        ], $this->customFields());
    }

    protected function customFields()
    {
        $fields = app(FieldtypeManager::class)->allFields('channel');

        return $fields->flatMap(function($field) {
            return [
                $field->field_name => new Fields\Fieldtype([
                        'type' => app(FieldtypeRegistrar::class)->getTypeForField($field) ?: \GraphQL\Type\Definition\Type::string(),
                        'field' => $field,
                        'selectable' => false,
                        'is_relation' => false,
                        'resolve' => function ($root, array $args) use($field) {
                            return $root->{$field->field_name};
                        }
                    ])
            ];
        })->toArray();
    }
}
