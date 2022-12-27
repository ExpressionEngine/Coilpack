<?php


namespace Expressionengine\Coilpack\Models\Category;

use ExpressionEngine\Model\Content\FieldModel;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\FieldtypeManager;

/**
 * Category Field Model
 */
class CategoryField extends Model
{
    protected $primaryKey = 'field_id';
    protected $table = 'category_fields';

    protected $casts = array(
        'field_ta_rows' => 'integer',
        'field_maxl' => 'integer',
        'field_required' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_show_fmt' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_order' => 'integer',
        'field_settings' => 'json',
        'legacy_field_data' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    );

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
        // cache this
        return app(FieldtypeManager::class)->make($this->field_type, $this->field_id);
    }

}


