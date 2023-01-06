<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

class ChannelEntryVersion extends Model
{
    protected $primaryKey = 'version_id';

    protected $table = 'entry_versioning';

    protected $casts = [
        'entry_id' => 'integer',
        'channel_id' => 'integer',
        'author_id' => 'integer',
        'version_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'version_data' => \Expressionengine\Coilpack\Casts\Serialize::class,
    ];

    public function entry()
    {
        return $this->belongsTo(ChannelEntry::class, 'entry_id');
    }

    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }
}
