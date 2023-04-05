<?php

namespace Expressionengine\Coilpack\Models\Member;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Channel Data Model
 */
class MemberData extends Model
{
    protected $primaryKey = 'member_id';

    protected $table = 'member_data';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function scopeCustomFields($query, $fields = null)
    {
        $fields = ($fields) ?: MemberField::all();

        if (! $fields || $fields->isEmpty()) {
            return $query;
        }

        $this->fields = $fields;

        // Get a set of table names for fields that do not store data on the legacy table
        $fieldtypeTables = $fields->filter(function ($field) {
            return $field->m_legacy_field_data === false || $field->m_legacy_field_data === 'n';
        })->map(function ($field) {
            return $field->data_table_name;
        });

        // Join these extra field data tables
        // https://www.quora.com/How-do-I-override-a-max-limit-of-61-joins-in-a-MySQL-query
        foreach ($fieldtypeTables as $table) {
            $query->leftJoin($table, "$table.member_id", '=', $this->qualifyColumn('member_id'));
        }

        // Make sure that we don't have a join nullifying our member_id
        $query->select('*', $this->qualifyColumn('member_id'));
    }

    public function fields()
    {
        $fields = MemberField::all()->keyBy('m_field_id');

        return collect(array_keys($this->attributes))->filter(function ($key) {
            return Str::startsWith($key, 'm_field_');
        })->reduce(function ($carry, $key) use ($fields) {
            [$name, $id] = array_slice(explode('_', $key), 2);

            if (! $fields->has($id)) {
                return $carry;
            }

            if (! $carry->has($id)) {
                $carry->put($id, new FieldContent(array_merge(
                    [
                        'field_type_id' => (int) $id,
                        'field' => $fields->find($id),
                        'member' => $this->member,
                    ],
                    Arr::only($this->attributes, ['member_id', 'site_id', 'channel_id'])
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
            return $content->field->m_field_name;
        });
    }
}
