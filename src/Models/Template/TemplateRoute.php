<?php

namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

/**
 * Template Route Model
 *
 * A model representing a template route.
 */
class TemplateRoute extends Model
{
    protected $primaryKey = 'route_id';

    protected $table = 'template_routes';

    protected $casts = [
        'order' => 'integer',
        'route_required' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    protected static $_relationships = [
        'Template' => [
            'type' => 'BelongsTo',
        ],
    ];
}
