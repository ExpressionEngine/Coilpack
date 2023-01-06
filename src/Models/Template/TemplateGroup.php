<?php

namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

/**
 * Template Group Model
 */
class TemplateGroup extends Model
{
    protected $primaryKey = 'group_id';

    protected $table = 'template_groups';

    protected $casts = [
        'is_site_default' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    protected static $_relationships = [
        'Roles' => [
            'type' => 'HasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => [
                'table' => 'template_groups_roles',
                'left' => 'template_group_id',
                'right' => 'role_id',
            ],
        ],
        'Templates' => [
            'type' => 'HasMany',
            'model' => 'Template',
        ],
        'Site' => [
            'type' => 'BelongsTo',
        ],
    ];
}
