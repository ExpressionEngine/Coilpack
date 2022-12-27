<?php


namespace Expressionengine\Coilpack\Models\Template;

use FilesystemIterator;
use Expressionengine\Coilpack\Model;
use ExpressionEngine\Service\Model\FileSyncedModel;
use ExpressionEngine\Library\Filesystem\Filesystem;

/**
 * Global Variable Model
 */
class GlobalVariable extends Model
{
    protected $primaryKey = 'variable_id';
    protected $table = 'global_variables';

    protected static $_hook_id = 'global_variable';

    protected static $_relationships = array(
        'Site' => array(
            'type' => 'belongsTo'
        )
    );

}


