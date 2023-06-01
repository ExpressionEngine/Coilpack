<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\Addon\Fluid\Data as FluidData;
use Expressionengine\Coilpack\Models\Channel\ChannelFieldGroup;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\FieldGroupContent;
use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;
use Illuminate\Database\Eloquent\Collection;

class FluidFieldPresenter extends Presenter
{
    use HasArgumentsAndParameters;

    public function present(FieldContent $content, $arguments)
    {
        $usingGroups = array_key_exists('field_channel_field_groups', $content->field->field_settings ?? []);
        $groupIds = $content->field->field_settings['field_channel_field_groups'] ?? [];
        $fieldIds = $content->field->field_settings['field_channel_fields'] ?? [];

        $fields = collect($groupIds)->reduce(function ($carry, $group) {
            return $carry->merge(app(FieldtypeManager::class)->fieldsForFieldGroup($group));
        }, new Collection)->merge(collect($fieldIds)->reduce(function ($carry, $field) {
            return $carry->push(app(FieldtypeManager::class)->getField($field));
        }, new Collection));

        if ($content->entry->isPreview()) {
            $order = 0;
            $groups = ChannelFieldGroup::whereIn('group_id', $groupIds)->get();

            $data = collect($content->data['fields'] ?? [])->flatMap(function ($value, $key) use ($fields, $groups, $usingGroups, &$order) {
                $groupId = null;
                $fieldGroup = null;

                if ($usingGroups) {
                    $groupId = array_filter(array_keys($value), function ($key) {
                        return strpos($key, 'field_group_id_') === 0;
                    })[0];
                    $value = $value[$groupId];
                    $groupId = str_replace('field_group_id_', '', $groupId);
                    $fieldGroup = $groups->find($groupId);
                }

                $rows = array_filter(array_keys($value), function ($key) {
                    return strpos($key, 'field_id_') === 0;
                });

                $result = [];

                foreach ($rows as $rowKey) {
                    $row = $value[$rowKey];
                    $fieldId = str_replace('field_id_', '', $rowKey);
                    $field = $fields->find($fieldId);

                    $result[] = (object) array_merge([
                        'id' => $key,
                        'field_id' => $fieldId,
                        'order' => $order++,
                        'group' => $groupId,
                        'field' => $field,
                        'fieldGroup' => $fieldGroup,
                        "field_ft_$fieldId" => $field->field_fmt,
                    ], [$rowKey => $row]);
                }

                return $result;
            });
        } else {
            $data = FluidData::query()
                ->customFields($fields)
                ->with($usingGroups ? ['field', 'fieldGroup'] : ['field'])
                ->where((new FluidData)->qualifyColumn('entry_id'), $content->entry_id)
                ->where('fluid_field_id', $content->field->field_id)
                ->orderBy('order')
                ->get();
        }

        $data = $data->map(function ($row) use ($content) {
            return new FieldContent(
                array_merge($content->getAttributes(), [
                    '_field_name' => $row->field->field_name,
                    '_field_type' => $row->field->field_type,
                    'fluid_field' => $content->field,
                    'fluid_order' => $row->order,
                    'fluid_group' => $row->group,
                    'fluid_field_data_id' => $row->id,
                    'field' => $row->field,
                    'group' => $row->fieldGroup,
                    'data' => $row->{'field_id_'.$row->field_id},
                    'format' => $row->{'field_ft_'.$row->field_id},
                    // Fieldtype should be optional, filled in by FieldContent
                    'fieldtype' => $row->field->getFieldtype(),
                ])
            );
        });

        if ($usingGroups) {
            $data = $data->reduce(function ($carry, $row) use ($content) {
                $key = $content->entry->isPreview() ? "{$row->fluid_group}_{$row->fluid_order}" : $row->fluid_group;
                if (! $carry->has($key)) {
                    $carry->put($key, $row->group ? new FieldGroupContent($row->group) : $row);
                }

                // Add the fields into their group
                if ($row->group) {
                    $group = $carry->get($key);
                    $group->fields()->push($row);
                }

                return $carry;
            }, collect());
        }

        return $data;
    }
}
