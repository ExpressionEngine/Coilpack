<?php

namespace Expressionengine\Coilpack;

use Expressionengine\Coilpack\Api\Graph\Support\FieldtypeRegistrar;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
// use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CoilpackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/coilpack.php' => config_path('coilpack.php'),
        ], 'coilpack-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'coilpack');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CoilpackCommand::class,
                Commands\GraphQLCommand::class,
            ]);
        }

        // Load ExpressionEngine in this phase if we're in an artisan/cli context
        if (defined('ARTISAN_BINARY')) {
            (new Bootstrap\LoadExpressionEngine)->cli()->bootstrap(app());
        }

        Route::macro('templates', new Routing\TemplateRoute);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Event::listen(function (\Illuminate\Routing\Events\RouteMatched $event) {
            // Prevent Coilpack from finishing the boot process if we're handling the request with EE
            if ($event->route->isFallback || $event->route->uri == config('coilpack.admin_url', 'admin.php')) {
                return;
            }

            $core = (new Bootstrap\LoadExpressionEngine)->bootstrap(app());

            if (! $core) {
                return;
            }

            // Handle ACT requests even on Laravel routes
            // Many EE modules rely on sending an ACT request to the base url
            // i.e. /index.php?ACT=XX or /?ACT=XX so we need to always listen
            if (request()->has('ACT')) {
                $response = $core->runGlobal();

                // Override the route action
                $event->route->setAction([
                    'uses' => function () use ($response) {
                        return $response;
                    },
                ]);
            }

            $core->loadSnippets();

            ee()->load->library('api');
            ee()->legacy_api->instantiate('channel_fields');

            // Only boot the GraphQL fieldtype registrar when needed
            if (\Illuminate\Support\Str::startsWith($event->route->uri, config('graphql.route.prefix'))) {
                app(FieldtypeRegistrar::class)->boot();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->recursiveMergeConfigFrom(
            __DIR__.'/../config/coilpack.php',
            'coilpack'
        );

        // The TwigBridge provider should already be auto-registered
        // $this->app->register(\TwigBridge\ServiceProvider::class);

        // Allow the ee() helper to be called as app('ee') in case that's more
        // desirable for integration with Laravel projects
        $this->app->singleton('ee', function ($app, $parameters) {
            if (! function_exists('ee')) {
                (new Bootstrap\LoadExpressionEngine)->bootstrap($app);
            }

            return ee(...$parameters);
        });

        // Register the FieldtypeManager and boot it
        $this->app->singleton(FieldtypeManager::class, function ($app) {
            $manager = new FieldtypeManager;
            $manager->boot();

            return $manager;
        });

        // Register the FieldtypeRegistrar and boot it
        $this->app->singleton(FieldtypeRegistrar::class, function ($app) {
            $registrar = new FieldtypeRegistrar($app->make(FieldtypeManager::class));
            $registrar->boot();

            return $registrar;
        });

        // Register our Exp view object as a singleton
        $this->app->singleton(\Expressionengine\Coilpack\View\Exp::class, function ($app) {
            return new \Expressionengine\Coilpack\View\Exp;
        });

        // Extend the Redirector so we can handle EE's calls to redirect() in the control panel
        $this->app->extend(\Illuminate\Routing\Redirector::class, function ($service, $app) {
            $redirector = new Routing\Redirector($service->getUrlGenerator());
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });

        // Replace the view.finder service so we can handle EE's .group folders
        $this->app->bind('view.finder', function ($app) {
            return new \Expressionengine\Coilpack\View\FileViewFinder($app['files'], $app['config']['view.paths']);
        });

        // Bind the implementation for Coilpack's facade
        $this->app->bind('coilpack', function ($app) {
            return new Coilpack;
        });

        $this->app->bind('coilpack.graphql', function ($app) {
            return new Api\Graph\SchemaManager;
        });

        // Register Middleware
        $this->app->make('router')->aliasMiddleware('member_with_role', Middleware\MemberWithRole::class);
        $this->app->make('router')->aliasMiddleware('member_with_permission', Middleware\MemberWithPermission::class);

        // Configure the behavior of the GraphQL schema based on package config
        $this->app->booting(function () {
            if (config('coilpack.graphql.enabled', false)) {
                app('coilpack.graphql')->enable();
            }

            if (config('coilpack.graphql.is_default_schema', true)) {
                app('coilpack.graphql')->setAsDefault();
            }

            if (is_null(env('ENABLE_GRAPHIQL')) && ! config('coilpack.graphql.graphiql', false)) {
                app('coilpack.graphql')->disableGraphiQL();
            }
        });
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function recursiveMergeConfigFrom($path, $key)
    {
        if (! ($this->app instanceof \Illuminate\Contracts\Foundation\CachesConfiguration && $this->app->configurationIsCached())) {
            $config = $this->app->make('config');

            $config->set($key, array_replace_recursive(
                require $path,
                $config->get($key, [])
            ));
        }
    }
}
