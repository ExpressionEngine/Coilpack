<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Channel Entry
 *
 * An entry in a content channel.  May have multiple custom fields in
 * addition to a number of built in fields.  Is content and may be
 * rendered on the front end.  Has a publish form that includes its
 * many fields as sub publish elements.
 *
 * Related to Channel which defines the structure of this content.
 */
class ChannelField extends Model implements Field
{
    protected $primaryKey = 'field_id';

    protected $table = 'channel_fields';

    protected $casts = [
        'field_pre_populate' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_pre_channel_id' => 'integer',
        'field_pre_field_id' => 'integer',
        'field_ta_rows' => 'integer',
        'field_maxl' => 'integer',
        'field_required' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_search' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_is_hidden' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_is_conditional' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_show_fmt' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'field_order' => 'integer',
        'field_settings' => \Expressionengine\Coilpack\Casts\Base64Serialized::class,
        'legacy_field_data' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channels_channel_fields', 'field_id', 'channel_id', 'field_id', 'channel_id');
    }

    public function fieldGroups()
    {
        return $this->belongsToMany(ChannelFieldGroup::class, 'channel_field_groups_fields', 'field_id', 'group_id', 'field_id', 'group_id');
    }

    public function hasDataTable()
    {
        // cache this check
        return Schema::connection($this->connection)->hasTable($this->data_table_name);
    }

    public function gridColumns()
    {
        return $this->hasMany(\Expressionengine\Coilpack\Models\Addon\Grid\Column::class, 'field_id');
    }

    public function getDataTableNameAttribute($value)
    {
        return "channel_data_field_{$this->field_id}";
    }

    public function getFieldType()
    {
        // cache this
        return app(FieldtypeManager::class)->make($this->field_type, $this->field_id);
    }

    public function getGraphType()
    {
        return $this->getFieldType()->getGraphType($this);
    }
}
