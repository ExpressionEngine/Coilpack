<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Expressionengine\Coilpack\Contracts\GeneratesGraphType;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\View\FilteredParameterValue;
use Illuminate\Support\Facades\DB;

class Grid extends Fieldtype implements GeneratesGraphType, ListsGraphType
{
    public function apply(FieldContent $content, $parameters = [])
    {
        $data = $this->loadData($content, $parameters);

        return FieldtypeOutput::make($data);
    }

    protected function loadData(FieldContent $content, $parameters = [])
    {
        if (! isset($content->entry_id)) {
            return [];
        }
        $isFluid = isset($content->fluid_field);

        $parameters = array_merge([
            'orderby' => 'row_order',
            'sort' => 'asc',
            'limit' => 100,
            'offset' => 0,
        ], $parameters);

        $tableName = "channel_grid_field_{$content->field->field_id}";
        $query = DB::connection('coilpack')
            ->table($tableName)
            ->where('entry_id', $content->entry_id)
            ->when($isFluid, function ($query) {
                $query->where('fluid_field_data_id', '!=', 0);
            });

        // Handle ordering
        if ($parameters['fixed_order'] ?? false) {
            $query->whereIn('row_id', $parameters['fixed_order']);
            $query->orderByRaw('FIELD(row_id, '.implode(',', $parameters['fixed_order']).')');
        } else {
            $direction = ($parameters['sort'] == 'asc') ? 'asc' : 'desc';
            $query->orderBy($parameters['orderby'], $direction);
        }

        // Filter by row ids
        if ($parameters['row_id'] ?? false) {
            $rowIds = new FilteredParameterValue($parameters['row_id']);
            $rowIds->filterQueryWithColumn($query, 'row_id');
        }

        // Handle offset
        if ($parameters['offset']) {
            $query->skip($parameters['offset']);
        }

        $data = $query->take($parameters['limit'])->get();

        $columns = $content->field->gridColumns;

        // maybe we want to persist $data from the query before we do any filtering?
        $data = $data->filter(function ($row) use ($isFluid, $content) {
            return ! $isFluid || $row->fluid_field_data_id == $content->fluid_order;
        })->map(function ($row) use ($columns, $content) {
            $columns->each(function ($column) use ($row, $content) {
                $row->{$column->col_name} = new FieldContent(
                    array_merge($content->getAttributes(), [
                        'data' => $row->{'col_id_'.$column->col_id},
                        'grid_row_id' => $row->row_id,
                        'grid_col_id' => $column->col_id,
                        'fieldtype' => app(FieldtypeManager::class)->make($column->col_type),
                    ])
                );
            });

            return $row;
        });

        return $data;
    }

    public function generateGraphType(ChannelField $field)
    {
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
    }
}
