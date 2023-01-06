<?php

namespace Expressionengine\Coilpack\Models\Security;

use Expressionengine\Coilpack\Model;

/**
 * Throttle Model
 */
class Throttle extends Model
{
    protected $primaryKey = 'throttle_id';

    protected $table = 'throttle';

    protected static $_validation_rules = [
        'ip_address' => 'ip_address',
    ];

    protected $throttle_id;

    protected $ip_address;

    protected $last_activity;

    protected $hits;

    protected $locked_out;
}
