<?php

namespace Expressionengine\Coilpack\Models\Member;

use Expressionengine\Coilpack\Model;

/**
 * Online Member
 */
class Online extends Model
{
    protected $primaryKey = 'online_id';

    protected $table = 'online_users';

    protected static $_relationships = [
        'Member' => [
            'type' => 'belongsTo',
        ],
        'Site' => [
            'type' => 'belongsTo',
        ],
    ];

    protected $casts = [
        'online_id' => 'integer',
        'site_id' => 'integer',
        'member_id' => 'integer',
        'in_forum' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'name' => 'string',
        'ip_address' => 'string',
        'date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'anon' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];
}
