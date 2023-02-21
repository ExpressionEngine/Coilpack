<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Expressionengine\Coilpack\FieldtypeManager;
use Illuminate\Contracts\Foundation\Application;

class LoadAddonFiles
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (empty(config('coilpack.expressionengine'))) {
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
                app(\Expressionengine\Coilpack\View\Exp::class)->registerTag(
                    $provider->getPrefix().'.'.$name,
                    $class
                );
            }
        }
    }
}
