<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\GeneratedInputType;
use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\FieldtypeOutput;
// use Expressionengine\Coilpack\Models\FieldContent;
use GraphQL\Type\Definition\Type;

abstract class Modifier implements ConvertsToGraphQL
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
        return implode('__', [
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
     * @param  FieldtypeOutput  $content
     * @param  array  $parameters
     * @return FieldtypeOutput
     */
    abstract public function handle(FieldtypeOutput $content, $parameters = []);

    public function toGraphQL(): array
    {
        $default = [
            'type' => Type::boolean(),
            'description' => $this->description,
        ];

        if (empty($this->parameters)) {
            return $default;
        }

        if ($this->parameters instanceof ConvertsToGraphQL) {
            return array_merge($default, $this->parameters->toGraphQL());
        }

        if ($this->parameters instanceof Type) {
            return array_merge($default, ['type' => $this->parameters]);
        }

        $name = $this->getQualifiedName();

        $typeDefinition = new GeneratedInputType([
            'name' => $name,
            'fields' => function () {
                return collect($this->parameters)->flatMap(function ($parameter, $key) {
                    $key = ($parameter->name ?? false) ? $parameter->name : $key;

                    return [
                        $key => $parameter instanceof ConvertsToGraphQL ? $parameter->toGraphQL() : $parameter,
                    ];
                })->toArray();
            },
        ]);

        return array_merge($default, [
            'type' => GraphQL::addType($typeDefinition, $name),
        ]);
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
