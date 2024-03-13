<?php

namespace Expressionengine\Coilpack\Support;

use Expressionengine\Coilpack\Api\Graph\Support\GeneratedInputType;
use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;

class Parameter implements ConvertsToGraphQL
{
    protected $attributes = [
        'name' => '',
        'prefix' => null,
        'type' => 'string',
        'defaultValue' => null,
        'description' => '',
        'rules' => [],
    ];

    public function __construct($attributes = [])
    {
        $this->attributes = array_merge(
            $this->attributes,
            Arr::only($attributes, array_keys($this->attributes))
        );
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        return $this->attributes[$key] = $value;
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function toGraphQL(): array
    {
        $type = $this->getGraphType($this->type);

        $output = [
            'type' => $type,
            'description' => $this->description,
        ];

        if ($this->defaultValue) {
            $output['defaultValue'] = $this->defaultValue;
        }

        return $output;
    }

    protected function getGraphType($type)
    {
        if (is_callable($type)) {
            $type = $type();
        }

        if (is_array($type)) {
            $parameters = array_filter($type, function ($value) {
                return $value instanceof self;
            });

            $type = new GeneratedInputType([
                'name' => implode('_', array_filter([
                    'Parameter_',
                    $this->prefix,
                    $this->name,
                ])),
                'fields' => collect($parameters)->flatMap(function ($parameter) {
                    $parameter->prefix = $this->name;

                    return [
                        $parameter->name => $parameter->toGraphQL(),
                    ];
                })->toArray(),
            ]);

            // make sure type is registered
            $type = GraphQL::addType($type, $type->name);

            return $type;
        }

        $map = [
            'string' => Type::string(),
            'boolean' => Type::boolean(),
            'integer' => Type::int(),
            'float' => Type::float(),
        ];

        return array_key_exists($type, $map) ? $map[$type] : $map['string'];
    }

    public function validate($input)
    {
        if (empty($this->rules)) {
            return true;
        }

        return false;
    }
}
