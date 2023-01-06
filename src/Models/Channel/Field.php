<?php

namespace Expressionengine\Coilpack\Models\Channel;

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
class Field extends Model
{
    protected $primaryKey = 'field_id';

    protected $table = 'channel_fields';

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
