<?php

namespace Expressionengine\Coilpack\Models\Template;

use Expressionengine\Coilpack\Model;

/**
 * Global Variable Model
 */
class GlobalVariable extends Model
{
    protected $primaryKey = 'variable_id';

    protected $table = 'global_variables';

    protected static $_hook_id = 'global_variable';

    protected static $_relationships = [
        'Site' => [
            'type' => 'belongsTo',
        ],
    ];
}
