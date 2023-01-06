<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;

/**
 * Channel Form Settings Model
 */
class ChannelFormSettings extends Model
{
    protected $primaryKey = 'channel_form_settings_id';

    protected $table = 'channel_form_settings';

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
