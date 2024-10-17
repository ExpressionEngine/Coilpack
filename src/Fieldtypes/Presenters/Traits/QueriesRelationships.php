<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters\Traits;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Str;

trait QueriesRelationships
{
    public function buildRelationshipQuery(FieldContent $content, Model $model, $tableName = null)
    {
        $isGrid = $content->field->field_type === 'grid' || ! empty($content->grid_row_id ?? 0);
        $isFluid = $content->hasAttribute('fluid_field');
        $fluidFieldId = ($isFluid) ? $content->fluid_field_data_id : 0;

        $query = $model::query();
        $tableName = $tableName ?: Str::singular($model->getTable()).'_relationships';

        if ($content->entry->isPreview()) {
            $query->whereIn($model->getKeyName(), $content->data['data'] ?? [0]);
        } else {
            $query->select("{$model->getTable()}.*")
                ->join($tableName, $model->getKeyName(), '=', 'child_id')
                ->when($isFluid, function ($query) use ($fluidFieldId, $tableName) {
                    $query->where("$tableName.fluid_field_data_id", $fluidFieldId);
                }, function ($query) use ($tableName) {
                    $query->where("$tableName.fluid_field_data_id", 0);
                })
                ->when($isGrid, function ($query) use ($content, $tableName) {
                    $query->where("$tableName.grid_field_id", $content->field->field_id)
                        ->where("$tableName.grid_row_id", $content->grid_row_id)
                        ->where("$tableName.grid_col_id", $content->grid_col_id);
                }, function ($query) use ($content, $tableName) {
                    $query->where("$tableName.field_id", $content->field->field_id)
                        ->where("$tableName.grid_field_id", 0);
                })
                ->where("$tableName.parent_id", $content->entry_id)
                ->orderBy('order');
        }

        return $query;
    }
}
