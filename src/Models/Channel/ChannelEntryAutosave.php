<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

class ChannelEntryAutosave extends Model
{
    protected $primaryKey = 'entry_id';

    protected $table = 'channel_entries_autosave';

    protected $casts = [
        'entry_data' => 'json',
    ];

    public function entry()
    {
        return $this->belongsTo(ChannelEntry::class, 'original_entry_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }
}
