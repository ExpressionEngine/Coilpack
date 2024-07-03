<?php

namespace Expressionengine\Coilpack;

/**
 * Base Model
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'coilpack';

    protected static $modelsShouldPreventAccessingMissingAttributes = false;
}
