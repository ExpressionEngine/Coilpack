<?php

namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

/**
 * Snippet Model
 */
class Snippet extends Model
{
    protected $primaryKey = 'snippet_id';

    protected $table = 'snippets';

    protected static $_relationships = [
        'Site' => [
            'type' => 'BelongsTo',
        ],
    ];
}
