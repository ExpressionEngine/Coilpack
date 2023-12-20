<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\Api\Graph\Support\GeneratedType;
use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Contracts\GeneratesGraphType;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Presenters\GridPresenter;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;

class Grid extends Fieldtype implements GeneratesGraphType, ListsGraphType
{
    protected $presenter;

    public function __construct(string $name, $id = null)
    {
        parent::__construct($name, $id);
        $this->presenter = new GridPresenter;
    }

    public function apply(FieldContent $content, array $parameters = [])
    {
        $data = $this->presenter->present($content, $parameters);

        return FieldtypeOutput::for($this)->value($data);
    }

    public function generateGraphType(ChannelField $field)
    {
        return new GeneratedType([
            'fields' => function () use ($field) {
                return $field->gridColumns->flatmap(function ($column) {
                    return [
                        $column->col_name => new \Expressionengine\Coilpack\Api\Graph\Fields\Fieldtype([
                            'description' => $column->col_instructions,
                            'fieldtype' => app(FieldtypeManager::class)->make($column->col_type),
                            'type' => app(FieldtypeRegistrar::class)->getType($column->col_type) ?: \GraphQL\Type\Definition\Type::string(),
                            'selectable' => false,
                            // 'is_relation' => false,
                            'resolve' => function ($root, array $args) use ($column) {
                                $value = $root->{$column->col_name}; //->value();

                                return $value;
                            },
                        ]),
                    ];
                })->toArray();
            },
        ]);
    }

    public function parametersForField(Field $field = null): array
    {
        $parameters = $this->presenter->defineParameters();
        $parameters[] = new Parameter([
            'name' => 'search',
            'prefix' => $field->field_name,
            'description' => 'Search for rows matching a certain criteria',
            'type' => function () use ($field) {
                return $field->gridColumns->flatmap(function ($column) {
                    return [
                        new Parameter([
                            'name' => $column->col_name,
                            'type' => 'string',
                            'description' => $column->col_instructions,
                        ]),
                    ];
                })->toArray();
            },
        ]);

        return $parameters;
    }
}
