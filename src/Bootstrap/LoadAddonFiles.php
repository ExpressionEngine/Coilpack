<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Expressionengine\Coilpack\Facades\GraphQL;
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
            $prefix = $provider->getPrefix();

            foreach ($bindings['graphql']['types'] ?? [] as $name => $type) {
                GraphQL::addType($type, $name);
            }

            foreach ($bindings['fieldtypes'] ?? [] as $name => $class) {
                app(FieldtypeManager::class)->register($name, $class);
            }

            foreach ($bindings['tags'] ?? [] as $name => $class) {
                app(\Expressionengine\Coilpack\View\Exp::class)->registerTag("{$prefix}.{$name}", $class);
            }

            foreach ($bindings['graphql']['queries'] ?? [] as $name => $query) {
                GraphQL::addQuery($query, strtolower("exp_{$prefix}_{$name}"));
            }
        }
    }
}
