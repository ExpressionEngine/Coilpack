<?php

namespace Expressionengine\Coilpack\Models\Security;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

/**
 * Reset Password Model
 */
class ResetPassword extends Model
{
    protected $primaryKey = 'reset_id';

    protected $table = 'reset_password';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
