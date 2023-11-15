<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LoadExpressionEngine
{
    public static $core = null;

    protected $constants;

    protected $basePath;

    protected $systemPath;

    protected $configPath;

    public $dependentBootstrappers = [
        LoadConfiguration::class,
        CreateDatabaseConnection::class,
        ConfigureStorageDisk::class,
    ];

    public function __construct()
    {
        $path = config('coilpack.base_path');
        $absolute = (Str::startsWith($path, DIRECTORY_SEPARATOR));
        $this->basePath = Str::finish($absolute ? $path : base_path($path), DIRECTORY_SEPARATOR);
        $this->systemPath = realpath($this->basePath.config('coilpack.system_path', 'system')).DIRECTORY_SEPARATOR;
        $this->configPath = realpath($this->basePath.config('coilpack.config_path')).DIRECTORY_SEPARATOR;

        if (empty($_SERVER['DOCUMENT_ROOT'])) {
            $_SERVER['DOCUMENT_ROOT'] = realpath($this->basePath);
        }

        $this->constants = [
            'BOOT_CORE_ONLY' => true,
            'INSTALL_MODE' => false,
            'REQ' => defined('ARTISAN_BINARY') ? 'CLI' : 'PAGE', // Error handler causing problems in CLI mode
            // 'BOOT_ONLY' => TRUE,
            'DEBUG' => config('app.debug') ? 2 : 0,
            // Path constants
            'SYSPATH' => $this->systemPath,
            'SYSDIR' => basename($this->systemPath),
            // 'FIXTURE' => TRUE);
            'SELF' => 'index.php',
            'EESELF' => 'index.php',
            'FCPATH' => $this->basePath,
            'BASEPATH' => realpath($this->systemPath.'/ee/legacy').'/',
        ];
    }

    public function asset()
    {
        $this->constants['REQ'] = 'ASSET';

        return $this;
    }

    public function cli()
    {
        // fake SERVER vars for CLI context
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $this->constants['REQ'] = 'CLI';
        $this->constants['EE_INSTALLED'] = file_exists($this->constants['SYSPATH'].'user/config/config.php');

        return $this;
    }

    public function page()
    {
        $this->constants['REQ'] = 'PAGE';

        return $this;
    }

    public function controlPanel()
    {
        putenv('EE_INSTALL_MODE=FALSE');
        $this->constants['REQ'] = 'CP';
        $this->constants['MASKED_CP'] = true;
        $this->constants['SELF'] = config('coilpack.admin_url', config('coilpack.admin_url', 'admin.php'));
        $this->constants['EESELF'] = config('coilpack.admin_url', config('coilpack.admin_url', 'admin.php'));

        return $this;
    }

    public function admin()
    {
        $installerExists = file_exists($this->systemPath.'ee/installer/');
        $configFileExists = file_exists($this->configPath.'config.php');
        $configFileSize = filesize($this->configPath.'config.php');

        // Load installer if the folder exists and config hasn't been set
        if (env('EE_INSTALL_MODE', false) || ($installerExists && (! $configFileExists || $configFileSize == 0))) {
            return $this->installer();
        } elseif ($this->hasUpdater()) {
            return $this->updater();
        }

        return $this->controlPanel();
    }

    public function updater()
    {
        putenv('EE_INSTALL_MODE=TRUE');
        // It is important that the updater does not define BASEPATH
        // for the updater boot.php to correctly load the constants it
        // needs in the correct steps
        $this->constants = array_merge(
            Arr::except($this->constants, ['BASEPATH', 'BOOT_CORE_ONLY']),
            [
                'REQ' => 'CP',
                'MASKED_CP' => true,
                'SELF' => config('coilpack.admin_url', 'admin.php'),
                'EESELF' => config('coilpack.admin_url', 'admin.php'),
                'INSTALL_MODE' => true,
            ]
        );

        return $this;
    }

    public function installer()
    {
        putenv('EE_INSTALL_MODE=TRUE');
        $this->constants['REQ'] = 'CP';
        $this->constants['MASKED_CP'] = true;
        $this->constants['SELF'] = config('coilpack.admin_url', 'admin.php');
        $this->constants['EESELF'] = config('coilpack.admin_url', 'admin.php');
        $this->constants['INSTALL_MODE'] = true;

        // Offer some convenient defaults for install wizard
        $defaults = [
            'db_hostname' => env('DB_HOST'),
            'db_name' => env('DB_DATABASE'),
            'db_username' => env('DB_USERNAME'),
            'db_password' => env('DB_PASSWORD'),
        ];

        foreach ($defaults as $key => $value) {
            if (! isset($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }

        // The SCRIPT_FILENAME must match EESELF constant defined above.
        // The installer/controller/wizard.php file uses both values to determine the base_path
        $_SERVER['SCRIPT_FILENAME'] = realpath($this->basePath).Str::start(config('coilpack.admin_url', 'admin.php'), '/');
        // PHP_SELF is used to determine the site_url in installer/controller/wizard
        $_SERVER['PHP_SELF'] = Str::start(config('coilpack.admin_url', 'admin.php'), '/');

        return $this;
    }

    public function hasUpdater()
    {
        return file_exists($this->systemPath.'ee/updater/boot.php');
    }

    /**
     * Bootstrap the given application.
     *
     * @return \Expressionengine\Coilpack\Core
     */
    public function bootstrap(Application $app)
    {
        if (! realpath(($this->basePath))) {
            return;
        }

        if (static::$core) {
            $this->bootstrapDependencies($app);

            return static::$core;
        }

        if (request()->has('ACT') !== false) {
            $this->constants['REQ'] = 'ACTION';
        }

        if ($this->constants['REQ'] !== 'CP') {
            global $routing;
            $routing = [
                'directory' => '',
                'controller' => 'ee',
                'function' => 'index',
            ];
        }

        foreach ($this->constants as $constant => $value) {
            (defined($constant)) || define($constant, $value);
        }

        // Load the updater package if it's here
        if ($this->constants['REQ'] === 'CP' && $this->hasUpdater()) {
            require_once SYSPATH.'ee/updater/boot.php';
            exit();
        }

        $core = new \Expressionengine\Coilpack\Core(require_once SYSPATH.'ee/ExpressionEngine/Boot/boot.php');

        // Override ExpressionEngine error handler with Laravel
        (new \Illuminate\Foundation\Bootstrap\HandleExceptions)->bootstrap($app);

        $configOverrides = [
            'base_url' => Str::finish(ee()->config->item('base_url') ?: config('app.url'), '/'),
        ];

        foreach ($configOverrides as $key => $value) {
            ee()->config->set_item($key, $value);
            // this needs to be set as well because config->site_prefs is called during route and overwrites all set
            ee()->config->default_ini[$key] = $value;
        }

        if (! $this->constants['INSTALL_MODE']) {
            $application = $core->loadApplicationCore();
            ee()->set('coilpack', app('coilpack'));
            $application->setRequest(\ExpressionEngine\Core\Request::fromGlobals());
        }

        ee()->load->library('core');

        if (defined('ARTISAN_BINARY')) {
            $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
            ee()->core->bootstrap();

            ee()->remove('extensions');
            ee()->set('extensions', new \Expressionengine\Coilpack\Extensions);
            ee()->load->library('session');
        }

        // These are set in run_ee() but should be moved so we aren't duplicating here
        // @todo update in core
        ee()->core->native_plugins = ['markdown', 'rss_parser', 'xml_encode'];
        ee()->core->native_modules = [
            'block_and_allow', 'channel', 'comment', 'commerce', 'email',
            'file', 'filepicker', 'forum', 'ip_to_nation', 'member',
            'metaweblog_api', 'moblog', 'pages', 'query', 'relationship', 'rss',
            'rte', 'search', 'simple_commerce', 'spam', 'stats',
        ];

        if (! $this->constants['INSTALL_MODE']) {
            if ($this->constants['REQ'] !== 'CP') {
                ee()->core->bootstrap();
            } else {
                ee()->load->database();
                ee()->load->library('extensions');
            }

            $this->setupTemplateLibrary();

            // Pass through some of the Extensions library data that
            // was already queried so we don't duplicate the queries
            $extensions = new \Expressionengine\Coilpack\Extensions([
                'extensions' => ee()->extensions->extensions,
                'version_numbers' => ee()->extensions->version_numbers,
            ]);
            ee()->remove('extensions');
            ee()->set('extensions', $extensions);

            // Fire Coilpack Booted Event
            // \Illuminate\Support\Facades\Event::dispatch('coilpack:booted');
            if (ee()->extensions->active_hook('coilpack_booted') === true) {
                ee()->extensions->call('coilpack_booted');
            }
        }

        static::$core = $core;

        $this->bootstrapDependencies($app);

        return $core;
    }

    public function bootstrapDependencies($app)
    {
        $dependencies = [];

        if (! $this->constants['INSTALL_MODE'] && ! in_array($this->constants['REQ'], ['ASSET'])) {
            $dependencies[] = SetupCacheManager::class;
        }

        if (! in_array($this->constants['REQ'], ['CP', 'ASSET'])) {
            $dependencies[] = LoadAddonFiles::class;
            $dependencies[] = ReplaceTemplateTags::class;
            $dependencies[] = ConfigureAuthProvider::class;
        }

        $app->bootstrapWith(array_merge($this->dependentBootstrappers, $dependencies));
    }

    protected function setupTemplateLibrary()
    {
        ee()->load->library('template');
        ee()->remove('TMPL');
        ee()->set('TMPL', new \Expressionengine\Coilpack\View\TemplateStub());
        ee()->TMPL->log_item('Using Coilpack Template Library');

        ee()->load->library('api');
        ee()->legacy_api->instantiate('template_structure');

        if (method_exists(ee()->api_template_structure, 'register_template_engine')) {
            ee()->api_template_structure->register_template_engine(['twig' => 'Twig', 'blade' => 'Blade']);
        }

        // Tell Laravel where the EE templates live and how to interpret new extensions
        app('view')->addNamespace('ee', SYSPATH.'user/templates');
        // adding too many extensions could slow down template rendering by
        // causing more file_exists checks so we're only looking for files
        // ending in `.twig` or `.blade` The TwigBridge sets up .twig ext
        app('view')->addExtension('blade', 'blade');
        // app('config')->push('view.paths', SYSPATH . 'user/templates/'); // PATH_TMPL not available yet
    }
}
