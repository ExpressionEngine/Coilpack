<?php


namespace Expressionengine\Coilpack\Models\Security;

use Expressionengine\Coilpack\Model;

/**
 * Captcha Model
 */
class Captcha extends Model
{
    protected $primaryKey = 'captcha_id';
    protected $table = 'captcha';

    protected static $_validation_rules = array(
        'ip_address' => 'ip_address'
    );

    protected $captcha_id;
    protected $date;
    protected $ip_address;
    protected $word;
}


