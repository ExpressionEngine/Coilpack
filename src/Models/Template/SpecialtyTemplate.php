<?php

namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

/**
 * Specialty Templates Model
 */
class SpecialtyTemplate extends Model
{
    protected $primaryKey = 'template_id';

    protected $table = 'specialty_templates';

    protected $casts = [
        'enable_template' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    protected static $_relationships = [
        'Site' => [
            'type' => 'BelongsTo',
        ],
        'LastAuthor' => [
            'type' => 'BelongsTo',
            'model' => 'Member',
            'from_key' => 'last_author_id',
            'weak' => true,
        ],
    ];
}
