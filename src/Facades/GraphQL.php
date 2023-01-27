<?php

namespace Expressionengine\Coilpack\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Expressionengine\Coilpack\Coilpack
 */
class GraphQL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'coilpack.graphql';
    }
}
