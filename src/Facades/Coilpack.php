<?php

namespace Expressionengine\Coilpack\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Expressionengine\Coilpack\Coilpack
 */
class Coilpack extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'coilpack';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    public static function routes(array $options = [])
    {
        static::$app->make('router')->coilpack($options);
    }
}
