<?php

namespace Expressionengine\Coilpack\Models\Security;

use Expressionengine\Coilpack\Model;

/**
 * Security Hash Model
 */
class SecurityHash extends Model
{
    protected $primaryKey = 'hash_id';

    protected $table = 'security_hashes';

    protected static $_relationships = [
        'Session' => [
            'type' => 'belongsTo',
        ],
    ];
}
