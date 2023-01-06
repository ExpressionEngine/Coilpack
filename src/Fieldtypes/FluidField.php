<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\Addon\Fluid\Data as FluidData;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Facades\DB;

class FluidField extends Fieldtype
{
    public function apply(FieldContent $content, array $parameters = [])
    {
        $data = $this->loadData($content);

        return FieldtypeOutput::make($data);
    }

    protected function loadData(FieldContent $content)
    {
        $fields = app(FieldtypeManager::class)->fieldsForChannel($content->entry->channel);
        $data = FluidData::query()
            ->customFields($fields)
            ->with('field')
            ->where((new FluidData)->qualifyColumn('entry_id'), $content->entry_id)
            ->where('fluid_field_id', $content->field->field_id)
            ->orderBy('order')
            ->get();

        return $data->map(function ($row) use ($content) {
            return new FieldContent(
                array_merge($content->getAttributes(), [
                    'fluid_field' => $content->field,
                    'fluid_order' => $row->order,
                    'field' => $row->field,
                    'data' => $row->{'field_id_'.$row->field_id},
                    'format' => $row->{'field_ft_'.$row->field_id},
                    // Fieldtype should be optional, filled in by FieldContent
                    'fieldtype' => app(FieldtypeManager::class)->make($row->field->field_type),
                ])
            );
        });

        $tableName = "channel_grid_field_{$content->field->field_id}";
        $data = DB::connection('coilpack')
            ->table($tableName)
            ->where('entry_id', $content->entry_id)
            ->orderBy('row_order')
            ->get();

        $columns = $content->field->gridColumns; //->keyBy('col_id');

        $data = $data->map(function ($row) use ($columns, $content) {
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
}
