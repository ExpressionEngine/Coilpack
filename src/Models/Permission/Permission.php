<?php

namespace Expressionengine\Coilpack\Models\Permission;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Role\Role;
use Expressionengine\Coilpack\Models\Site\Site;

/**
 * Permission Model
 */
class Permission extends Model
{
    protected $primaryKey = 'permission_id';
    protected $table = 'permissions';

    protected $casts = [
        'permission_id' => 'integer',
        'role_id' => 'integer',
        'site_id' => 'integer',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }


}


