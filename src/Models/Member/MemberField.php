<?php

namespace Expressionengine\Coilpack\Models\Member;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;

/**
 * Member Field Model
 */
class MemberField extends Model
{
    protected $primaryKey = 'm_field_id';

    protected $table = 'member_fields';

    protected $casts = [
        'm_field_settings' => 'json',
        'm_field_exclude_from_anon' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'm_legacy_field_data' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    public function getFieldType()
    {
        // cache this
        return app(FieldtypeManager::class)->make($this->m_field_type, $this->m_field_id, 'member');
    }

    public function getDataTableNameAttribute($value)
    {
        return "member_data_field_{$this->m_field_id}";
    }
}
