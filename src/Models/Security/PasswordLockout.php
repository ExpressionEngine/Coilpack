<?php

namespace Expressionengine\Coilpack\Models\Security;

use Expressionengine\Coilpack\Model;

/**
 * Password Lockout Model
 */
class PasswordLockout extends Model
{
    protected $primaryKey = 'lockout_id';

    protected $table = 'password_lockout';

    protected static $_validation_rules = [
        'ip_address' => 'ip_address',
    ];

    protected $lockout_id;

    protected $login_date;

    protected $ip_address;

    protected $user_agent;

    protected $username;
}
