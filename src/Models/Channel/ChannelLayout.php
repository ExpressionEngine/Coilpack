<?php


namespace Expressionengine\Coilpack\Models\Channel;

use InvalidArgumentException;
use Expressionengine\Coilpack\Model;
use ExpressionEngine\Model\Content\Display\LayoutDisplay;
use ExpressionEngine\Model\Content\Display\LayoutInterface;
use ExpressionEngine\Model\Content\Display\LayoutTab;

/**
 * Channel Layout Model
 */
class ChannelLayout extends Model implements LayoutInterface
{
    protected $primaryKey = 'layout_id';
    protected $table = 'layout_publish';

    protected static $_hook_id = 'channel_layout';

    protected $casts = array(
        'field_layout' => \Expressionengine\Coilpack\Casts\Serialize::class,
    );

    protected static $_relationships = array(
        'Channel' => array(
            'type' => 'belongsTo',
            'key' => 'channel_id'
        ),
        'PrimaryRoles' => array(
            'type' => 'hasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => array(
                'table' => 'layout_publish_member_roles',
                'key' => 'role_id',
            )
        ),
    );

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
