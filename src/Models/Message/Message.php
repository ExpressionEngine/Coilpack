<?php


namespace Expressionengine\Coilpack\Models\Message;

use Expressionengine\Coilpack\Model;

/**
 * Private message
 */
class Message extends Model
{
    protected $primaryKey = 'message_id';
    protected $table = 'message_data';

    protected static $_relationships = [
        'Member' => [
            'type' => 'belongsTo',
            'from_key' => 'sender_id'
        ],
        'Recipients' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Member',
            'pivot' => [
                'table' => 'message_copies',
                'left' => 'message_id',
                'right' => 'recipient_id'
            ]
        ]
    ];

    protected $casts = [
        'message_id' => 'integer',
        'sender_id' => 'integer',
        'message_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'message_subject' => 'string',
        'message_body' => 'string',
        'message_tracking' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_attachments' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_recipients' => 'string',
        'message_cc' => 'string',
        'message_hide_cc' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_sent_copy' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'total_recipients' => 'integer',
        'message_status' => 'string'
    ];

}



