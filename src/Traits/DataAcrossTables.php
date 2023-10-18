<?php

namespace Expressionengine\Coilpack\Traits;

use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait DataAcrossTables
{
    public function scopeCustomFields($query, $fields = null)
    {
        if (! $fields || $fields->isEmpty()) {
            return $query;
        }

        $keyName = 'entry_id';

        $this->fields = $fields;

        // Get a set of table names for fields that do not store data on the legacy table
        $fieldtypeTables = $fields->filter(function ($field) {
            return ! $field->hasLegacyFieldData();
        })->map(function ($field) {
            return $field->data_table_name;
        });

        // Join these extra field data tables
        // https://www.quora.com/How-do-I-override-a-max-limit-of-61-joins-in-a-MySQL-query
        foreach ($fieldtypeTables as $table) {
            $query->leftJoin($table, "$table.$keyName", '=', $this->qualifyColumn($keyName));
        }

        // Make sure that we don't have a join nullifying our $keyName
        $query->select('*', $this->qualifyColumn($keyName));
    }

    public function fields()
    {
        $fields = app(FieldtypeManager::class)->fieldsForChannel($this->entry->channel);

        return collect(array_keys($this->attributes))->filter(function ($key) {
            return Str::startsWith($key, 'field_');
        })->reduce(function ($carry, $key) use ($fields) {
            [$name, $id] = array_slice(explode('_', $key), 1);

            if (! $fields->has($id)) {
                return $carry;
            }

            if (! $carry->has($id)) {
                $carry->put($id, new FieldContent(array_merge(
                    [
                        'field_type_id' => (int) $id,
                        'field' => $fields->find($id),
                        'entry' => $this->entry,
                    ],
                    Arr::only($this->attributes, ['entry_id', 'site_id', 'channel_id'])
                )));
            }

            $nameMap = [
                'id' => 'data',
                'ft' => 'format',
            ];

            $carry->get($id)->setAttribute($nameMap[$name], $this->attributes[$key]);

            return $carry;
        }, collect([]))->keyBy(function ($content) {
            return $content->field->field_name;
        });
    }
}
