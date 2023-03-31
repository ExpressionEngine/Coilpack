<?php

namespace Expressionengine\Coilpack\Models\Category;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;

/**
 * Category Field Model
 */
class CategoryField extends Model implements Field
{
    protected $primaryKey = 'field_id';

    protected $table = 'category_fields';

    protected $casts = [
        'field_ta_rows' => 'integer',
        'field_maxl' => 'integer',
        'field_required' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_show_fmt' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_order' => 'integer',
        'field_settings' => 'json',
        'legacy_field_data' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    public function group()
    {
        return $this->belongsTo(CategoryGroup::class);
    }

    public function getDataTableNameAttribute($value)
    {
        return "category_field_data_field_{$this->field_id}";
    }

    public function getFieldType()
    {
        // We are not passing the id because Api_Channel_Fields only handles channel field ids
        $id = null; // $this->field_id

        // cache this
        return app(FieldtypeManager::class)
            ->make($this->field_type, $id, 'category')
            ->withSettings($this->field_settings);
    }
}
