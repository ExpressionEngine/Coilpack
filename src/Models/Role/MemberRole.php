<?php

namespace Expressionengine\Coilpack\Models\Role;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

/**
 * Role Model
 */
class MemberRole extends Model
{
    protected $primaryKey = 'member_id';

    protected $table = 'members_roles';

    public function members()
    {
        return $this->hasMany(Member::class, 'member_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'role_id');
    }
}
