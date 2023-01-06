<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;
use ExpressionEngine\Model\Content\Display\LayoutInterface;

/**
 * Channel Layout Model
 */
class ChannelLayout extends Model implements LayoutInterface
{
    protected $primaryKey = 'layout_id';

    protected $table = 'layout_publish';

    protected static $_hook_id = 'channel_layout';

    protected $casts = [
        'field_layout' => \Expressionengine\Coilpack\Casts\Serialize::class,
    ];

    protected static $_relationships = [
        'Channel' => [
            'type' => 'belongsTo',
            'key' => 'channel_id',
        ],
        'PrimaryRoles' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => [
                'table' => 'layout_publish_member_roles',
                'key' => 'role_id',
            ],
        ],
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
