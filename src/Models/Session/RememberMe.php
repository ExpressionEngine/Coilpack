<?php


namespace Expressionengine\Coilpack\Models\Session;

use Expressionengine\Coilpack\Model;

use Expressionengine\Coilpack\Models\Member\Member;

/**
 * Remember Me Model
 */
class RememberMe extends Model
{
    protected $primaryKey = 'remember_me_id';
    protected $table = 'remember_me';

    protected static $_relationships = array(
        'Member' => array(
            'type' => 'BelongsTo'
        ),
        'Site' => array(
            'type' => 'BelongsTo'
        )
    );

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

}


