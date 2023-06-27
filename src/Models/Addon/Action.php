<?php

namespace Expressionengine\Coilpack\Models\Addon;

use Expressionengine\Coilpack\Model;

/**
 * Action Model
 */
class Action extends Model
{
    protected $primaryKey = 'action_id';

    protected $table = 'actions';

    // Available as a replacement to ee()->functions->fetch_action_id
    public static function fetch_action_id($class, $method)
    {
        $action = static::select('action_id')->where('class', $class)->where('method', $method)->first();

        if (! $action) {
            throw new \Exception("Could not find action for '$class:$method', please make sure the module is installed.");
        }

        return $action->action_id;
    }
}
