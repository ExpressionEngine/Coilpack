<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
        // Check to see if there is a cached configuration file.  If one exists
        // then Coilpack does not need to look for Expression Engine's config
        // file.  Everything will have already been loaded and cached.
        if (is_file($cached = $app->getCachedConfigPath())) {
            $loadedFromCache = true;
        }

        // If the config is not cached we will need to look through the file
        // where ExpressionEngine is storing it's configuration and load it.
        if (! isset($loadedFromCache)) {
            $this->loadConfigurationFiles($app, app('config'));
        }
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
            require $path;

            if (! empty($config)) {
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
        $configPath = realpath($basePath.config('coilpack.config_path', 'system/user/config'));

        if (! defined('BASEPATH')) {
            $systemPath = realpath($basePath.config('coilpack.system_path', 'system')).DIRECTORY_SEPARATOR;
            define('BASEPATH', realpath($systemPath.'/ee/legacy').'/');
        }

        if (File::missing($configPath)) {
            return $files;
        }

        if (! file_exists($configPath.DIRECTORY_SEPARATOR.'config.php')) {
            app('log')->warning("Config path $configPath may be incorrect, missing config.php.");

            return $files;
        }

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
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
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }
}
