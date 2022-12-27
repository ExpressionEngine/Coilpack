<?php


namespace Expressionengine\Coilpack\Models\Role;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;
use Expressionengine\Coilpack\Models\Permission\Permission;

/**
 * Role Model
 */
class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $table = 'roles';

    protected $casts = [
        'role_id' => 'integer',
        'is_locked' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_id');
    }

    public function settings()
    {
        return $this->hasMany(RoleSetting::class, 'role_id');
    }

    public function groups()
    {
        return $this->belongsToMany(RoleGroup::class, 'roles_role_groups', 'role_id', 'group_id');
    }

    public function primaryMembers()
    {
        return $this->hasMany(Member::class, 'role_id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'members_roles', 'role_id');
    }

}


