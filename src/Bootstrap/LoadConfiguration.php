<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class LoadConfiguration
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        // $items = [];

        // // First we will see if we have a cache configuration file. If we do, we'll load
        // // the configuration items from that file so that it is very quick. Otherwise
        // // we will need to spin through every configuration file and load them all.
        // if (is_file($cached = $app->getCachedConfigPath())) {
        //     $items = require $cached;

        //     $loadedFromCache = true;
        // }

        // Next we will spin through all of the configuration files in the configuration
        // directory and load each one into the repository. This will make all of the
        // options available to the developer for use in various parts of this app.
        // $app->instance('config', $config = new Repository($items));

        // if (!isset($loadedFromCache)) {
            $this->loadConfigurationFiles($app, app('config'));
        // }
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $repository
     * @return void
     *
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($app);

        foreach ($files as $key => $path) {
            $config = [];
            require($path);

            if (!empty($config)) {
                $repository->set('coilpack.expressionengine', $config);
            }

        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];
        $path = config('coilpack.base_path');
        $absolute = (Str::startsWith($path, DIRECTORY_SEPARATOR));
        $basePath = Str::finish($absolute ? $path : base_path($path), DIRECTORY_SEPARATOR);
        $configPath = realpath($basePath . config('coilpack.config_path', 'system/user/config'));

        if(!defined('BASEPATH')) {
            $systemPath = realpath($basePath . config('coilpack.system_path', 'system')) . DIRECTORY_SEPARATOR;
            define('BASEPATH', realpath($systemPath . '/ee/legacy') . '/',);
        }

        if(File::missing($configPath)) {
            return $files;
        }

        if(!file_exists($configPath . DIRECTORY_SEPARATOR . 'config.php')) {
            app('log')->warning("Config path $configPath may be incorrect, missing config.php.");
            return $files;
        }

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested) . '.';
        }

        return $nested;
    }
}
