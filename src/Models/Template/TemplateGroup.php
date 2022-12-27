<?php


namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

use ExpressionEngine\Library\Filesystem\Filesystem;

/**
 * Template Group Model
 */
class TemplateGroup extends Model
{
    protected $primaryKey = 'group_id';
    protected $table = 'template_groups';


    protected $casts = array(
        'is_site_default' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    );

    protected static $_relationships = array(
        'Roles' => array(
            'type' => 'HasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => array(
                'table' => 'template_groups_roles',
                'left' => 'template_group_id',
                'right' => 'role_id'
            )
        ),
        'Templates' => array(
            'type' => 'HasMany',
            'model' => 'Template'
        ),
        'Site' => array(
            'type' => 'BelongsTo'
        )
    );

}


