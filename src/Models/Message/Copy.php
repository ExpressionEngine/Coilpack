<?php


namespace Expressionengine\Coilpack\Models\Message;

use Expressionengine\Coilpack\Model;

/**
 * Message Copy
 *
 * Represents delivery of a message to a single member
 */
class Copy extends Model
{
    protected $primaryKey = 'copy_id';
    protected $table = 'message_copies';

    protected static $_relationships = [
        'Message' => [
            'type' => 'belongsTo',
            'model' => 'Message'
        ],
        'Sender' => [
            'type' => 'belongsTo',
            'model' => 'Member',
            'from_key' => 'sender_id'
        ],
        'Recipient' => [
            'type' => 'belongsTo',
            'model' => 'Member',
            'from_key' => 'recipient_id'
        ]
    ];

    protected $casts = [
        'copy_id' => 'integer',
        'message_id' => 'integer',
        'sender_id' => 'integer',
        'recipient_id' => 'integer',
        'message_received' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_read' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_time_read' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'attachment_downloaded' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_authcode' => 'string',
        'message_deleted' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'message_status' => 'string'
    ];

}



