<?php

namespace Expressionengine\Coilpack\Models\Message;

use Expressionengine\Coilpack\Model;

/**
 * Folder
 *
 * Folders for private messages
 */
class Folder extends Model
{
    protected $primaryKey = 'member_id';

    protected $table = 'message_folders';

    protected static $_relationships = [
        'Member' => [
            'type' => 'belongsTo',
        ],
    ];

    protected $casts = [
        'member_id' => 'integer',
        'folder1_name' => 'string',
        'folder2_name' => 'string',
        'folder3_name' => 'string',
        'folder4_name' => 'string',
        'folder5_name' => 'string',
        'folder6_name' => 'string',
        'folder7_name' => 'string',
        'folder8_name' => 'string',
        'folder9_name' => 'string',
        'folder10_name' => 'string',
    ];
}
