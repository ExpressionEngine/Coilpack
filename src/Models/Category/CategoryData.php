<?php

namespace Expressionengine\Coilpack\Models\Category;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Category Data Model
 */
class CategoryData extends Model
{
    protected $primaryKey = 'cat_id';

    protected $table = 'category_field_data';

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function scopeCustomFields($query, $fields = null)
    {
        if (! $fields || $fields->isEmpty()) {
            return $query;
        }

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
            $query->leftJoin($table, "$table.cat_id", '=', $this->qualifyColumn('cat_id'));
        }

        // Make sure that we don't have a join nullifying our cat_id
        $query->select('*', $this->qualifyColumn('cat_id'));
    }

    public function fields($category, $group = null)
    {
        $group = $group ?? $category->group;
        $fields = app(FieldtypeManager::class)->fieldsForCategoryGroup($group)->keyBy('field_id');

        return collect(array_keys($this->attributes))->filter(function ($key) {
            return Str::startsWith($key, 'field_');
        })->reduce(function ($carry, $key) use ($fields, $category) {
            [$name, $id] = array_slice(explode('_', $key), 1);

            if (! $fields->has($id)) {
                return $carry;
            }

            if (! $carry->has($id)) {
                $carry->put($id, new FieldContent(array_merge(
                    [
                        'field_type_id' => (int) $id,
                        'field' => $fields->find($id),
                        'category' => $category,
                    ],
                    Arr::only($this->attributes, ['cat_id', 'site_id', 'channel_id'])
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
