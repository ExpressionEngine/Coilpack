<?php


namespace Expressionengine\Coilpack\Models\Template;

use FilesystemIterator;
use Expressionengine\Coilpack\Model;
use ExpressionEngine\Service\Model\FileSyncedModel;
use ExpressionEngine\Library\Filesystem\Filesystem;

/**
 * Snippet Model
 */
class Snippet extends Model
{
    protected $primaryKey = 'snippet_id';
    protected $table = 'snippets';

    protected static $_relationships = array(
        'Site' => array(
            'type' => 'BelongsTo'
        )
    );

}


