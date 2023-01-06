<?php

namespace Expressionengine\Coilpack\Api\Graph\Fields;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\Models\FieldContent;
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

    public function args(): array
    {
        $fieldtype = $this->getFieldtype();
        $modifiers = ($fieldtype) ? $fieldtype->modifiers() : [];

        $args = collect($modifiers)->transform(function ($modifier) {
            return $modifier->toGraphQL();
        });

        return $args->toArray();
    }

    protected function resolve($root, array $args)
    {
        if ($this->attributes['resolve'] ?? false && is_callable($this->attributes['resolve'])) {
            $data = $this->attributes['resolve']($root, $args);
        } else {
            $data = $root->{$this->getProperty()};
        }

        // apply modifiers;
        if (! empty($args)) {
            foreach ($args as $key => $value) {
                return $data->callModifier($key, $value);
            }
        }
        // return !empty($root->{$this->field->field_name}) ?: new FieldContent(['fieldtype' => $this->field->field_type]);
        return $data;
    }

    protected function getProperty(): string
    {
        return $this->attributes['alias'] ?? $this->attributes['name'];
    }
}
