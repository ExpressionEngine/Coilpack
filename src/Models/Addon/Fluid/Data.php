<?php

namespace Expressionengine\Coilpack\Models\Addon\Fluid;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models as Models;
use Illuminate\Support\Facades\DB;

class Data extends Model
{
    protected $primaryKey = 'entry_id';

    protected $table = 'fluid_field_data';

    public function fluidField()
    {
        return $this->belongsTo(Models\Channel\ChannelField::class, 'field_id', 'fluid_field_id');
    }

    public function field()
    {
        return $this->belongsTo(Models\Channel\ChannelField::class, 'field_id');
    }

    public function entry()
    {
        return $this->belongsTo(Models\Channel\ChannelEntry::class, 'entry_id');
    }

    public function scopeCustomFields($query, $fields = null)
    {
        if (! $fields || $fields->isEmpty()) {
            return $query;
        }

        $this->fields = $fields;

        // Get a set of table names for fields that do not store data on the legacy table
        $fields = $fields->filter(function ($field) {
            return $field->legacy_field_data == 'n' || $field->legacy_field_data === false || $field->hasDataTable();
        });

        // Join these extra field data tables
        // https://www.quora.com/How-do-I-override-a-max-limit-of-61-joins-in-a-MySQL-query
        foreach ($fields as $field) {
            $table = $field->data_table_name;
            $query->leftJoin($table, function ($join) use ($table, $field) {
                $join->on("$table.entry_id", '=', DB::raw(0)); // Fluid fields store their data in entry_id=0
                $join->on("$table.id", '=', $this->qualifyColumn('field_data_id'));
                $join->on($this->qualifyColumn('field_id'), '=', DB::raw($field->field_id));
            });
        }

        // Make sure that we don't have a join nullifying our entry_id
        $query->select('*', $this->qualifyColumn('entry_id'), $this->qualifyColumn('id'));
    }
}
