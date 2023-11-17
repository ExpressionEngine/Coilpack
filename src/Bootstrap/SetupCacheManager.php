<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SetupCacheManager
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $path = config('coilpack.base_path');
        $absolute = (Str::startsWith($path, DIRECTORY_SEPARATOR));
        $basePath = Str::finish($absolute ? $path : base_path($path), DIRECTORY_SEPARATOR);

        if (! realpath($basePath) || (ee()->has('cache') && ee()->cache instanceof \Expressionengine\Coilpack\CacheManager)) {
            return;
            // throw new \Exception('ExpressionEngine folder missing.');
        }

        $overrideConfig = Arr::only(ee()->config->config, [
            'uri_protocol',
            'directory_trigger',
            'controller_trigger',
            'function_trigger',
            'enable_query_strings',
        ]);

        ee()->core->bootstrap();

        // we need these variables to stay in the config after bootstrapping
        foreach ($overrideConfig as $key => $value) {
            ee()->config->set_item($key, $value);
        }

        $cache = new \Expressionengine\Coilpack\CacheManager(ee()->cache);

        ee()->remove('cache');
        ee()->set('cache', $cache);
    }
}
