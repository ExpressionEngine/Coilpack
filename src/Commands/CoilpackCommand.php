<?php

namespace Expressionengine\Coilpack\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CoilpackCommand extends Command
{
    public $signature = 'coilpack {--dev} {--force} {--source} {--install=}';

    public $description = 'Setup Coilpack';

    private $minimumVersionSupported = '7.2.3';

    public function handle(): int
    {
        if (! $this->option('force') && config('coilpack.expressionengine.app_version') !== null) {
            $this->info(vsprintf('ExpressionEngine %s already installed at %s.', [
                config('coilpack.expressionengine.app_version'),
                config('coilpack.base_path'),
            ]));

            if (version_compare(config('coilpack.expressionengine.app_version'), $this->minimumVersionSupported, '<')) {
                $this->warn(vsprintf(
                    'You are using a version of ExpressionEngine that is lower than the recommended version %s.'
                    .' Please upgrade as soon as possible.',
                    [
                        $this->minimumVersionSupported,
                    ]
                ));
            }

            return self::SUCCESS;
        }

        if (! file_exists(config_path('coilpack.php'))) {
            $this->call('vendor:publish', ['--tag' => 'coilpack-config']);
        }

        if ($this->option('install')) {
            $type = 'install';
        } else {
            $type = $this->choice(
                'Would you like to install ExpressionEngine or choose an existing installation',
                ['install', 'choose'],
                'install'
            );
        }

        if ($type == 'install') {
            $this->install();
        } else {
            $this->choose();
        }

        $this->updateRoutesFile();

        $this->askForStar();

        return self::SUCCESS;
    }

    public function choose()
    {
        $path = $this->ask('Enter the path where your ExpressionEngine installation is located (Default: '.config('coilpack.base_path').')') ?: config('coilpack.base_path');
        $basePath = realpath($path);

        if (! file_exists($path)) {
            $this->error("Path does not exist: $path");

            return self::FAILURE;
        }

        // Locate ExpressionEngine System folder
        $system = $this->ask('Enter the relative path to your system folder (Default: '.config('coilpack.system_path').')') ?: config('coilpack.system_path');
        $systemPath = Str::finish($path, DIRECTORY_SEPARATOR).ltrim($system, DIRECTORY_SEPARATOR);

        if (! realpath($systemPath) || ! file_exists(realpath($systemPath))) {
            $this->error("Cannot find system folder at: $systemPath");

            return self::FAILURE;
        }

        $systemPath = realpath($systemPath);

        // Locate ExpressionEngine Config folder
        $config = $this->ask('Enter the relative path to your config folder (Default: '.config('coilpack.config_path').')') ?: config('coilpack.config_path');
        $configPath = Str::finish($path, DIRECTORY_SEPARATOR).ltrim($config, DIRECTORY_SEPARATOR);

        if (! realpath($configPath) || ! file_exists(realpath($configPath))) {
            $this->error("Cannot find config folder at: $configPath");

            return self::FAILURE;
        }

        $configPath = realpath($configPath);

        // Update config
        $this->updateConfigValue('base_path', (Str::startsWith($path, '.')) ? $path : $basePath);
        $this->updateConfigValue('system_path', $system);
        $this->updateConfigValue('config_path', $config);

        return $this->info("We have updated `config/coilpack.php` to use your ExpressionEngine installation at $path");
    }

    private function updateConfigValue($key, $value)
    {
        $content = file_get_contents(config_path('coilpack.php'));
        $search = "/'$key' => '.*',$/m";
        $replace = "'$key' => '".$value."',";
        file_put_contents(config_path('coilpack.php'), preg_replace($search, $replace, $content));
    }

    private function updateRoutesFile()
    {
        $routesFile = base_path('routes/web.php');
        $content = file_get_contents($routesFile);

        $search = "Route::get('/', function () {\n"
        ."    return view('welcome');\n"
        ."});\n";

        if (! str_contains($content, $search)) {
            return;
        }

        $replace = "// Route::get('/', function () {\n"
        ."//    return view('welcome');\n"
        ."// });\n";

        file_put_contents($routesFile, str_replace($search, $replace, $content));

        $this->info("Coilpack has disabled the Laravel 'welcome' route to avoid routing conflicts.");
        $this->info('You may enable it at any time by uncommenting the route in `routes/web.php`.');
    }

    public function install()
    {
        if ($this->option('source')) {
            $releases = $this->branches();
        } else {
            $releases = $this->availableReleases();

            if (! $this->option('dev')) {
                $releases = $releases->filter(function ($release) {
                    return ! $release['prerelease'];
                });
            }

            $releases = $releases->slice(0, 10);
        }

        $this->comment('Coilpack supports the following ExpressionEngine Versions');

        if ($this->option('install')) {
            $release = ($this->option('install') == 'latest') ? $releases->first()['tag_name'] : $this->option('install');
        } else {
            $release = $this->choice('Which Release would you like to install?', $releases->pluck('tag_name')->all(), 0);
        }

        $this->installRelease($releases[$release]);

        $this->info("Finish installing {$release} at ".url(config('coilpack.admin_url', 'admin.php')));
    }

    public function availableReleases()
    {
        $url = 'https://api.github.com/repos/expressionengine/expressionengine/releases';

        return collect(Http::get($url)->json())->map(function ($release) {
            $fields = ['tag_name', 'name', 'prerelease', 'published_at'];
            $asset = current(array_filter($release['assets'], function ($asset) {
                return Str::endsWith($asset['browser_download_url'], '.zip');
            }));

            return array_merge(
                Arr::only($release, $fields),
                ['download_url' => $asset['browser_download_url']]
            );
        })->filter(function ($release) {
            return version_compare($release['tag_name'], $this->minimumVersionSupported, '>=');
        })->keyBy('tag_name');
    }

    public function branches()
    {
        $url = 'https://api.github.com/repos/expressionengine/expressionengine/branches?per_page=100';

        return collect(Http::get($url)->json())->map(function ($branch) {
            return [
                'name' => $branch['name'],
                'tag_name' => $branch['name'],
                'download_url' => "http://github.com/expressionengine/expressionengine/archive/{$branch['name']}.zip",
            ];
        })->keyBy('tag_name');
    }

    public function installRelease($release)
    {
        // Setup
        $localPath = storage_path("install/{$release['tag_name']}");
        $installPath = base_path(config('coilpack.base_path', 'ee'));

        if (! File::exists("{$localPath}/unpacked")) {
            File::makeDirectory("{$localPath}/unpacked", 0777, true, true);
        }

        if (! File::exists($installPath)) {
            File::makeDirectory($installPath, 0777, true);
        }

        // Download
        $this->info("Downloading {$release['name']}...");
        if (! File::exists("{$localPath}/download.zip")) {
            copy($release['download_url'], "{$localPath}/download.zip");
        }

        // Unpack
        $this->info("Unpacking file at {$localPath}/download.zip");
        if (count(File::glob("{$localPath}/unpacked/*", GLOB_NOSORT)) === 0) {
            $zip = new \ZipArchive;
            $res = $zip->open("{$localPath}/download.zip");
            if ($res === true) {
                $zip->extractTo("{$localPath}/unpacked");
                $zip->close();
            }
        }

        // Move and set permissions
        $this->info("Moving installation to $installPath");
        if ($this->option('force') || count(File::glob("{$installPath}/*", GLOB_NOSORT)) === 0) {
            File::moveDirectory("{$localPath}/unpacked", $installPath, true);

            $permissionsMap = [
                'system/user/config' => 0777,
                'system/user/cache' => 0777,
                'system/user/templates' => 0777,
                'system/user/language' => 0777,
                'images' => 0777,
                'themes/user' => 0777,
            ];

            // Recursively set permissions on directories
            foreach ($permissionsMap as $path => $permission) {
                $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator("$installPath/$path"));
                foreach ($iterator as $item) {
                    @chmod($item, $permission);
                }
            }
        }
    }

    protected function askForStar()
    {
        $url = 'https://github.com/expressionengine/coilpack';
        $question = "We're thrilled that you have chosen to use Coilpack! \n Would you like to tell others by starring our repo? (y/n)";
        $response = strtolower($this->ask($question, 'n'));

        // If we don't get a "y" or "yes" we're done
        if (! in_array($response, ['y', 'yes'])) {
            return;
        }

        // Choose the proper command to open the url based on the current operating system
        $openUrlCommands = [
            'Darwin' => 'open',
            'Linux' => 'xdg-open',
            'Windows' => 'start',
        ];

        $command = array_key_exists(PHP_OS_FAMILY, $openUrlCommands) ? $openUrlCommands[PHP_OS_FAMILY] : null;

        if (! $command) {
            $this->info("Oops, this is embarrassing. \n We can't open the url on your operating system but you can still star the repo: $url");
        }

        exec("$command $url");
    }
}
