<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use GraphQL\Type\Definition\Type;

abstract class Modifier
{
    protected $attributes;

    protected $fieldtype;

    public function __construct(Fieldtype $fieldtype, $attributes = [])
    {
        $this->fieldtype = $fieldtype;
        $this->attributes = $attributes;
    }

    public function forFieldtype(Fieldtype $fieldtype)
    {
        $this->fieldtype = $fieldtype;
    }

    public function getQualifiedName()
    {
        return implode('\\', [
            'Fieldtype',
            (new \ReflectionClass($this->fieldtype))->getShortName(),
            'Modifier',
            (new \ReflectionClass(static::class))->getShortName(),
            $this->name,
        ]);
    }

    /**
     * Modify the content
     *
     * @param  FieldContent  $content
     * @param  array  $parameters
     * @return FieldtypeOutput
     */
    abstract public function handle(FieldContent $content, $parameters = []);

    public function toGraphQL()
    {
        $type = Type::boolean();

        if ($this->parameters) {
            $type = app(FieldtypeRegistrar::class)->registerModifier($this);
            if (is_null($type)) {
                dd($this, $this->parameters);
            }
        }

        $defaults = [
            'type' => $type,
            // 'defaultValue' => null,
            'description' => '',
        ];

        return array_merge($defaults, array_filter($this->attributes['graphql'] ?? []));
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
    }
}
