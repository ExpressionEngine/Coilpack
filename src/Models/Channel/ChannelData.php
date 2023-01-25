<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Channel Data Model
 */
class ChannelData extends Model
{
    protected $primaryKey = 'entry_id';

    protected $table = 'channel_data';

    public function entry()
    {
        return $this->belongsTo(ChannelEntry::class, 'entry_id');
    }

    public function scopeCustomFields($query, $fields = null)
    {
        if (! $fields || $fields->isEmpty()) {
            return $query;
        }

        $this->fields = $fields;

        // Get a set of table names for fields that do not store data on the legacy table
        $fieldtypeTables = $fields->filter(function ($field) {
            return $field->legacy_field_data == 'n' || $field->legacy_field_data === false;
        })->map(function ($field) {
            return $field->data_table_name;
        });

        // Join these extra field data tables
        // https://www.quora.com/How-do-I-override-a-max-limit-of-61-joins-in-a-MySQL-query
        foreach ($fieldtypeTables as $table) {
            $query->leftJoin($table, "$table.entry_id", '=', $this->qualifyColumn('entry_id'));
        }

        // Make sure that we don't have a join nullifying our entry_id
        $query->select('*', $this->qualifyColumn('entry_id'));
    }

    public function fields($channel)
    {
        // $fields = $this->entry->channel->allFields();
        $channel = $channel ?? $this->entry->channel;
        $fields = app(FieldtypeManager::class)->fieldsForChannel($channel)->keyBy('field_id');

        return collect(array_keys($this->attributes))->filter(function ($key) {
            return Str::startsWith($key, 'field_');
        })->reduce(function ($carry, $key) use ($fields) {
            [$name, $id] = array_slice(explode('_', $key), 1);

            // Do not add the field if it isn't part of the entry's channel
            // or if it has been conditionally hidden for this entry
            if (! $fields->has($id) || $this->entry->hiddenFields->contains($id)) {
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
                'dt' => 'datetime',
            ];

            $carry->get($id)->setAttribute($nameMap[$name], $this->attributes[$key]);

            return $carry;
        }, collect([]))->keyBy(function ($content) {
            return $content->field->field_name;
        });
    }
}
