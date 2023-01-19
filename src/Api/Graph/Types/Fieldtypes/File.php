<?php

namespace Expressionengine\Coilpack\Api\Graph\Types\Fieldtypes;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class File extends GraphQLType
{
    protected $attributes = [
        'name' => 'Fieldtypes__File',
        'description' => 'File attributes',
    ];

    public function fields(): array
    {
        return [
            'file_name' => [
                'type' => Type::string(),
            ],

            // Set additional data based on what we've gathered
            'raw_output' => [
                'type' => Type::string(),
            ],
            'raw_content' => [
                'type' => Type::string(),
            ],
            'extension' => [
                'type' => Type::string(),
            ],
            'filename' => [
                'type' => Type::string(),
            ],

            'path' => [
                'type' => Type::string(),
            ],
            'url' => [
                'type' => Type::string(),
            ],

            'file_hw_original' => [
                'type' => Type::string(),
            ],

            'width' => [
                'type' => Type::int(),
            ],
            'height' => [
                'type' => Type::int(),
            ],

            // Pre and post formatting
            'image_pre_format' => [
                'type' => Type::string(),
            ],
            'image_post_format' => [
                'type' => Type::string(),
            ],
            'file_pre_format' => [
                'type' => Type::string(),
            ],
            'file_post_format' => [
                'type' => Type::string(),
            ],

            // Image/file properties
            'image_properties' => [
                'type' => Type::string(),
            ],
            'file_properties' => [
                'type' => Type::string(),
            ],

            'file_size_human' => [
                'type' => Type::string(),
                'resolve' => function ($root, array $args) {
                    return $root['file_size:human'];
                },
            ],
            'file_size_human_long' => [
                'type' => Type::string(),
                'resolve' => function ($root, array $args) {
                    return $root['file_size:human_long'];
                },
            ],

            'directory_id' => [
                'type' => Type::int(),
            ],
            'directory_title' => [
                'type' => Type::string(),
            ],
        ];
    }
}
