<?php

namespace Expressionengine\Coilpack\Models\Role;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Model\Site\Site;

/**
 * RoleSetting Model
 */
class RoleSetting extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'role_settings';

    protected $casts = [
        'role_id' => 'integer',
        'site_id' => 'integer',
        'menu_set_id' => 'integer',
        'exclude_from_moderation' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'search_flood_control' => 'integer',
        'prv_msg_send_limit' => 'integer',
        'prv_msg_storage_limit' => 'integer',
        'include_in_authorlist' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'include_in_memberlist' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'cp_homepage_channel' => 'integer',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
