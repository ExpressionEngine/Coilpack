<?php


namespace Expressionengine\Coilpack\Models\Message;

use Expressionengine\Coilpack\Model;

/**
 * Listed member
 *
 * Represents a member's place on another member's list, be it a buddy list or
 * block list
 */
class ListedMember extends Model
{
    protected $primaryKey = 'listed_id';
    protected $table = 'message_listed';

    protected static $_relationships = [
        'ListedByMember' => [
            'type' => 'belongsTo',
            'model' => 'Member'
        ],
        'Member' => [
            'type' => 'belongsTo',
            'from_key' => 'listed_member'
        ]
    ];

    protected $casts = [
        'listed_id' => 'integer',
        'member_id' => 'integer',
        'listed_member' => 'integer',
        'listed_description' => 'string',
        'listed_type' => 'string'
    ];

}



