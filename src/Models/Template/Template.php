<?php


namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;
use ExpressionEngine\Service\Model\FileSyncedModel;

/**
 * Template Model
 *
 * A model representing a template.  Templates contain a mix of EECode and HTML
 * and are parsed to become the front end pages of sites built with
 * ExpressionEngine.
 */
class Template extends Model
{
    protected $primaryKey = 'template_id';
    protected $table = 'templates';

    protected $casts = array(
        'cache' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'enable_http_auth' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'allow_php' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'protect_javascript' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'refresh' => 'integer',
        'hits' => 'integer',
    );

    protected static $_relationships = array(
        'Site' => array(
            'type' => 'BelongsTo'
        ),
        'TemplateGroup' => array(
            'type' => 'BelongsTo'
        ),
        'LastAuthor' => array(
            'type' => 'BelongsTo',
            'model' => 'Member',
            'from_key' => 'last_author_id',
            'weak' => true
        ),
        'Roles' => array(
            'type' => 'HasAndBelongsToMany',
            'model' => 'Role',
            'pivot' => array(
                'table' => 'templates_roles',
                'left' => 'template_id',
                'right' => 'role_id'
            )
        ),
        'TemplateRoute' => array(
            'type' => 'HasOne'
        ),
        'DeveloperLogItems' => array(
            'type' => 'hasMany',
            'model' => 'DeveloperLog'
        ),
        'Versions' => array(
            'type' => 'hasMany',
            'model' => 'RevisionTracker',
            'to_key' => 'item_id',
        )
    );

}


