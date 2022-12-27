<?php


namespace Expressionengine\Coilpack\Models\Message;

use Expressionengine\Coilpack\Model;

/**
 * Attachment
 *
 * Attachments sent via private messages
 */
class Attachment extends Model
{
    protected $primaryKey = 'attachment_id';
    protected $table = 'message_attachments';

    protected static $_relationships = [
        'Member' => [
            'type' => 'belongsTo',
            'from_key' => 'sender_id'
        ],
        'Message' => [
            'type' => 'belongsTo'
        ]
    ];

    protected $casts = [
        'attachment_id' => 'integer',
        'sender_id' => 'integer',
        'message_id' => 'integer',
        'attachment_name' => 'string',
        'attachment_hash' => 'string',
        'attachment_extension' => 'string',
        'attachment_location' => 'string',
        'attachment_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'attachment_size' => 'integer',
        'is_temp' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

}



