<?php

namespace Expressionengine\Coilpack\Api\Graph\Fields;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Field;

class FormattableDate extends Field
{
    protected $attributes = [
        'description' => 'A field that can output a date in all sorts of ways.',
    ];

    public function __construct(array $settings = [])
    {
        $this->attributes = \array_merge($this->attributes, $settings);
    }

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'format' => [
                'type' => Type::string(),
                'defaultValue' => 'Y-m-d H:i',
                'description' => 'Defaults to Y-m-d H:i',
            ],
            'relative' => [
                'type' => Type::boolean(),
                'defaultValue' => false,
            ],
        ];
    }

    protected function resolve($root, array $args): ?string
    {
        $date = $root->{$this->getProperty()};

        if (!$date instanceof \Carbon\Carbon) {
            return null;
        }

        if ($args['relative']) {
            return $date->diffForHumans();
        }

        return $date->format($args['format']);
    }

    protected function getProperty(): string
    {
        return $this->attributes['alias'] ?? $this->attributes['name'];
    }
}