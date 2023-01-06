<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Expressionengine\Coilpack\FieldtypeManager;
use Illuminate\Contracts\Foundation\Application;

class LoadAddonFiles
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (config('coilpack.expressionengine.app_version') === null) {
            return;
        }

        $coilpackProviders = array_filter(ee('App')->getProviders(), function ($provider) {
            return ! empty($provider->get('coilpack'));
        });

        foreach ($coilpackProviders as $provider) {
            $bindings = $provider->get('coilpack') ?? [];
            foreach ($bindings['fieldtypes'] ?? [] as $name => $class) {
                app(FieldtypeManager::class)->register($name, $class);
            }
            foreach ($bindings['tags'] ?? [] as $name => $class) {
                app(\Expressionengine\Coilpack\View\Exp::class)->registerTag($name, $class);
            }
        }
    }
}
