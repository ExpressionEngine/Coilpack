<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;

/**
 * Channel Field Group Model
 */
class ChannelFieldGroup extends Model
{
    protected $primaryKey = 'group_id';

    protected $table = 'field_groups';

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channels_channel_field_groups', 'group_id', 'channel_id', 'group_id', 'channel_id');
    }

    public function fields()
    {
        return $this->belongsToMany(ChannelField::class, 'channel_field_groups_fields', 'group_id', 'field_id', 'group_id', 'field_id');
    }
}
