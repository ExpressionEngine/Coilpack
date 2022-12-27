<?php


namespace Expressionengine\Coilpack\Models\Template;

use EE_Route;
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

    protected $casts = array(
        'order' => 'integer',
        'route_required' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    );

    protected static $_relationships = array(
        'Template' => array(
            'type' => 'BelongsTo'
        )
    );

}


