<?php


namespace Expressionengine\Coilpack\Models\Role;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

/**
 * RoleGroup Model
 */
class RoleGroup extends Model
{
    protected $primaryKey = 'group_id';
    protected $table = 'role_groups';

    protected $casts = [
        'group_id' => 'integer',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_role_groups', 'group_id', 'role_id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'members_role_groups', 'group_id', 'member_id');
    }
}


