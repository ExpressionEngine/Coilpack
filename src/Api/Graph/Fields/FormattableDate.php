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
            'timezone' => [
                'type' => Type::string(),
                'defaultValue' => null,
                'description' => 'Timezone defaults to UTC. Use "SYSTEM" for the value set in ExpressionEngine',
            ],
        ];
    }

    protected function resolve($root, array $args): ?string
    {
        $date = $root->{$this->getProperty()};

        if (is_int($date) && $date !== 0) {
            $date = \Carbon\Carbon::createFromTimestamp($date);
        }

        if (! $date instanceof \Carbon\Carbon) {
            return null;
        }

        if ($args['timezone']) {
            if ($args['timezone'] === 'SYSTEM') {
                $args['timezone'] = ee()->config->item('default_site_timezone') ?: date_default_timezone_get();
            }

            if (in_array($args['timezone'], \DateTimeZone::listIdentifiers())) {
                $date->setTimezone($args['timezone']);
            }
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
