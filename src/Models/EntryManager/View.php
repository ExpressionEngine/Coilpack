<?php

namespace Expressionengine\Coilpack\Models\EntryManager;

use Expressionengine\Coilpack\Model;

class View extends Model
{
    protected $primaryKey = 'view_id';

    protected $table = 'entry_manager_views';

    protected $casts = [
        'view_id' => 'integer',
        'member_id' => 'integer',
        'channel_id' => 'integer',
        'name' => 'string',
        'colums' => \Expressionengine\Coilpack\Casts\Serialize::class,
    ];

    protected static $_relationships = [
        'Members' => [
            'type' => 'belongsTo',
            'model' => 'Member',
        ],
        'Channels' => [
            'type' => 'belongsTo',
            'model' => 'Channel',
        ],
    ];
}
