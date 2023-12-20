<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Addon\Fluid\Data as FluidData;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;

class FluidFieldPresenter extends Presenter
{
    use HasArgumentsAndParameters;

    public function present(FieldContent $content, $arguments)
    {
        $fields = app(FieldtypeManager::class)->fieldsForChannel($content->entry->channel);

        if ($content->entry->isPreview()) {
            $order = 0;
            $data = collect($content->data['fields'] ?? [])->map(function ($value, $key) use ($fields, &$order) {
                $fieldId = array_filter(array_keys($value), function ($key) {
                    return strpos($key, 'field_id_') === 0;
                })[0];
                $fieldId = str_replace('field_id_', '', $fieldId);
                $field = $fields->find($fieldId);

                return (object) array_merge([
                    'id' => $key,
                    'field_id' => $fieldId,
                    'order' => $order++,
                    'field' => $field,
                    "field_ft_$fieldId" => $field->field_fmt,
                ], $value);
            });
        } else {
            $data = FluidData::query()
                ->customFields($fields)
                ->with('field')
                ->where((new FluidData)->qualifyColumn('entry_id'), $content->entry_id)
                ->where('fluid_field_id', $content->field->field_id)
                ->orderBy('order')
                ->get();
        }

        return $data->map(function ($row) use ($content) {
            return new FieldContent(
                array_merge($content->getAttributes(), [
                    'fluid_field' => $content->field,
                    'fluid_order' => $row->order,
                    'fluid_field_data_id' => $row->id,
                    'field' => $row->field,
                    'data' => $row->{'field_id_'.$row->field_id},
                    'format' => $row->{'field_ft_'.$row->field_id},
                    // Fieldtype should be optional, filled in by FieldContent
                    'fieldtype' => $row->field->getFieldtype(),
                ])
            );
        });
    }
}
