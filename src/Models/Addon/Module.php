<?php



namespace Expressionengine\Coilpack\Models\Addon;

use Expressionengine\Coilpack\Model;

/**
 * Module Model
 */
class Module extends Model
{
    protected $primaryKey = 'module_id';
    protected $table = 'modules';

    protected $casts = array(
        'has_cp_backend' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'has_publish_fields' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    );

    public function AssignedRoles()
    {
        return $this->hasMany(Expressionengine\Coilpack\Models\Role\Role::class, 'module_member_roles');
        // 'AssignedRoles' => array(
        //     'type' => 'hasAndBelongsToMany',
        //     'model' => 'Role',
        //     'pivot' => array(
        //         'table' => 'module_member_roles'
        //     )
        // ),
    }

    public function UploadDestination()
    {
        return $this->hasMany(Expressionengine\Coilpack\Models\File\UploadDestination::class);

        // 'UploadDestination' => array(
        //     'type' => 'hasMany'
        // )
    }
}


