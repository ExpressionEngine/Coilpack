<?php

namespace Expressionengine\Coilpack\Api\Graph\Fields;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Field;

class Fieldtype extends Field
{
    protected $field;

    protected $attributes = [
        'description' => 'A fieldtype field',
    ];

    public function __construct(array $settings = [])
    {
        $this->attributes = \array_merge($this->attributes, $settings);
    }

    public function setField($field)
    {
        $this->attributes['field'] = $field;

        return $this;
    }

    public function type(): Type
    {
        if ($this->attributes['type'] ?? false) {
            return $this->attributes['type'];
        }

        $type = app(FieldtypeRegistrar::class)->getTypeForField($this->field) ?: \GraphQL\Type\Definition\Type::string();

        return $type;
    }

    protected function getFieldtype()
    {
        if ($this->attributes['field'] ?? false) {
            return $this->attributes['field']->getFieldtype();
        } elseif ($this->attributes['fieldtype'] ?? false) {
            return $this->attributes['fieldtype'];
        }

        return null;
    }

    protected function parameters()
    {
        $field = $this->attributes['field'] ?? null;
        $fieldtype = $this->getFieldtype();

        return ($fieldtype) ? collect($fieldtype->parameters($field))->keyBy('name') : collect();
    }

    protected function modifiers()
    {
        $fieldtype = $this->getFieldtype();

        return ($fieldtype) ? $fieldtype->modifiers() : [];
    }

    public function args(): array
    {
        $modifiers = $this->modifiers();
        $parameters = $this->parameters();

        $args = $modifiers->map(function ($modifier) {
            return $modifier->toGraphQL();
        })->merge(collect($parameters)->map(function ($parameter) {
            return $parameter->toGraphQL();
        }));

        return $args->toArray();
    }

    protected function resolve($root, array $args)
    {
        if ($this->attributes['resolve'] ?? false && is_callable($this->attributes['resolve'])) {
            $data = $this->attributes['resolve']($root, $args);
        } else {
            $data = $root->{$this->getProperty()};
        }

        if (is_null($data)) {
            return $data;
        }

        if (! empty($args)) {
            // apply parameters
            $parameters = array_intersect_key($args, $this->parameters()->toArray());
            $output = $data->parameters($parameters);

            // Parameters take precedence over modifiers
            // Remove any arguments that were used as parameters
            $args = array_diff_key($args, $parameters);

            // apply modifiers
            $modifiers = array_intersect_key($args, $this->modifiers()->toArray());

            foreach ($modifiers as $key => $value) {
                $output = $output->$key($value);
            }

            return $output;
        }

        return $data->value();
    }

    protected function getProperty(): string
    {
        return $this->attributes['alias'] ?? $this->attributes['name'];
    }
}
