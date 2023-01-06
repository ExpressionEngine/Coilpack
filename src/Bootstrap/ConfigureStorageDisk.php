<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;

class ConfigureStorageDisk
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $path = config('coilpack.base_path');
        $absolute = (Str::startsWith($path, DIRECTORY_SEPARATOR));
        $basePath = Str::finish($absolute ? $path : base_path($path), DIRECTORY_SEPARATOR);

        if (! realpath($basePath)) {
            return;
            // throw new \Exception('ExpressionEngine folder missing.');
        }

        app('config')->set('filesystems.disks.coilpack', [
            'driver' => 'local',
            'root' => realpath($basePath),
        ]);
    }
}
