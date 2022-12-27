<?php


namespace Expressionengine\Coilpack\Models\Session;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

/**
 * Session Model
 */
class Session extends Model
{
    protected $primaryKey = 'session_id';
    protected $table = 'sessions';

    protected $casts = array(
        'can_debug' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    );

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}


