<?php


namespace Expressionengine\Coilpack\Models\Status;

use Expressionengine\Coilpack\Model;
use Mexitek\PHPColors\Color;

/**
 * Status Model
 */
class Status extends Model
{
    protected $primaryKey = 'status_id';
    protected $table = 'statuses';

    protected static $_hook_id = 'status';

    protected $casts = array(
        'site_id' => 'integer',
        'group_id' => 'integer',
        'status_order' => 'integer'
    );

    protected static $_relationships = array(
        'Channels' => array(
            'type' => 'hasAndBelongsToMany',
            'model' => 'Channel',
            'pivot' => array(
                'table' => 'channels_statuses'
            ),
            'weak' => true,
        ),
        'ChannelEntries' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntry',
            'weak' => true
        ],
        'Site' => array(
            'type' => 'BelongsTo'
        ),
        'Roles' => array(
            'type' => 'hasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => array(
                'table' => 'statuses_roles',
                'left' => 'status_id',
                'right' => 'role_id'
            )
        )
    );

}


