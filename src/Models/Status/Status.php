<?php

namespace Expressionengine\Coilpack\Models\Status;

use Expressionengine\Coilpack\Model;

/**
 * Status Model
 */
class Status extends Model
{
    protected $primaryKey = 'status_id';

    protected $table = 'statuses';

    protected static $_hook_id = 'status';

    protected $casts = [
        'site_id' => 'integer',
        'group_id' => 'integer',
        'status_order' => 'integer',
    ];

    protected static $_relationships = [
        'Channels' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Channel',
            'pivot' => [
                'table' => 'channels_statuses',
            ],
            'weak' => true,
        ],
        'ChannelEntries' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntry',
            'weak' => true,
        ],
        'Site' => [
            'type' => 'BelongsTo',
        ],
        'Roles' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => [
                'table' => 'statuses_roles',
                'left' => 'status_id',
                'right' => 'role_id',
            ],
        ],
    ];
}
