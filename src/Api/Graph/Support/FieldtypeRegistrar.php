<?php

namespace Expressionengine\Coilpack\Api\Graph\Support;

use Expressionengine\Coilpack\Contracts\GeneratesGraphType;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Fieldtypes\Fieldtype;
use Expressionengine\Coilpack\Fieldtypes\Modifier;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FieldtypeRegistrar
{
    protected $types = [];

    protected $inputs = [];

    protected $booted = false;

    public function __construct(FieldtypeManager $manager)
    {
        $this->fieldtypeManager = $manager;
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->registerFieldtypes();
        $this->registerFields();

        $this->booted = true;
    }

    /**
     * Register all of the
     *
     * @return void
     */
    public function registerFields()
    {
        // This list of fields is not including member fields now
        // Get a list of fields sorted with those that will generate a new type last
        $fields = $this->fieldtypeManager->allFields()->sortBy(function ($field) {
            return ($field->getFieldType() instanceof GeneratesGraphType) ? 1 : -1;
        });

        foreach ($fields as $field) {
            $this->registerField($field);
        }
    }

    public function registerFieldtypes()
    {
        $fieldtypes = $this->fieldtypeManager->allFieldtypes();

        foreach ($fieldtypes as $fieldtype) {
            $fieldtype = app(FieldtypeManager::class)->make($fieldtype->name);
            $this->registerFieldtype($fieldtype);
        }
    }

    public function registerModifier(Modifier $modifier)
    {
        $name = $modifier->getQualifiedName();

        if (array_key_exists($name, $this->inputs)) {
            return GraphQL::type($name);
        }

        if (empty($modifier->parameters)) {
            return null;
        }

        $typeDefinition = new GeneratedInputType([
            'name' => $name,
            'fields' => function () use ($modifier) {
                return $modifier->parameters;
            },
        ]);

        GraphQL::addType($typeDefinition, $name);

        $type = GraphQL::type($name);
        // $type = $name;

        $this->inputs[$name] = $type;

        return $type;
    }

    public function registerField(ChannelField $field)
    {
        $fieldtype = $field->getFieldType();

        if ($type = $this->registerFieldtype($fieldtype)) {
            return $type;
        }

        if (array_key_exists($field->field_name, $this->types)) {
            return $this->types[$field->field_name];
        }

        $name = "Field__{$field->field_name}";
        $typeDefinition = $fieldtype->generateGraphType($field);
        $typeDefinition->name = $name;

        GraphQL::addType($typeDefinition, $name);

        $type = $name;
        $this->types[$field->field_name] = $type;

        return $type;
    }

    public function registerFieldtype(Fieldtype $fieldtype)
    {
        if (array_key_exists($fieldtype->name, $this->types)) {
            return $this->types[$fieldtype->name];
        }

        if (! $fieldtype instanceof GeneratesGraphType) {
            $type = $fieldtype->graphType();
            $isGraphType = ($type instanceof GraphQLType || $type instanceof \GraphQL\Type\Definition\Type);

            if ($isGraphType) {
                $name = $type->name ?? "Fieldtype__{$fieldtype->name}";

                // Add the GraphQL type to the registry if needed
                if (! GraphQL::hasType($name)) {
                    $type->name = $name;
                    GraphQL::addType($type, $name);
                }

                $type = $name;
            }

            $this->types[$fieldtype->name] = $type;

            return $type;
        }
    }

    public function getTypeForField($field)
    {
        $possibleTypes = array_filter([
            $this->getType($field->field_name),
            $this->getType($field->field_type),
            $this->getType($field->m_field_type),
        ]);

        $type = array_shift($possibleTypes);
        if ($type === null) {
            dd($field->field_name, $field->field_type, $field->getFieldType(), $this->types);
        }

        $type = ($field->getFieldtype() instanceof ListsGraphType) ? Type::listOf($type) : $type;

        return $type;
    }

    public function getType($field)
    {
        $field = strtolower($field);

        if (array_key_exists($field, $this->types)) {
            $type = $this->types[$field];

            return (is_string($type)) ? GraphQL::type($type) : $this->types[$field];
        }

        return null;
    }
}
