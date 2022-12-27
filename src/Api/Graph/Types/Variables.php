<?php

namespace Expressionengine\Coilpack\Api\Graph\Types;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Variables extends GraphQLType
{
    protected $attributes = [
        'name' => 'Variables',
        'description' => 'Collection of Global Variables',
    ];


    public function fields(): array
    {
        $fields = [];
        $variables = (new \Expressionengine\Coilpack\View\Composers\GlobalComposer)->globals()['global'];

        foreach($variables as $key => $value) {
            $fields[$key] = $this->addField('Variables', $key, $value);
        }

        return $fields;
    }

    protected function addField($name, $key, $value)
    {
        if (is_array($value)) {
            $name = "$name\\$key";

            $typeDefinition = new GeneratedType([
                'name' => $name,
                'fields' => function () use ($name, $key, $value) {
                    $fields = [];
                    foreach ($value as $k => $v) {
                        $fields[$k] = $this->addField($name, $k, $v);
                    }
                    return $fields;
                }
            ]);

            GraphQL::addType($typeDefinition, $name);

            return [
                'name' => $key,
                'type' => GraphQL::type($name)
            ];
        }

        return [
            'name' => $key,
            'type' => (is_bool($value)) ? Type::boolean() : Type::string()
        ];
    }
}
