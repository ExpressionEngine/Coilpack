<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Expressionengine\Coilpack\Models\Permission\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ConfigureAuthProvider
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

        if (! realpath($basePath)) {
            return;
            // throw new \Exception('ExpressionEngine folder missing.');
        }

        app('auth')->extend('exp_sessions', function ($app, $name, $config) {
            // $session = $app->make('session')->driver('expressionengine');
            $prefix = ee()->config->item('cookie_prefix') ? ee()->config->item('cookie_prefix').'_' : 'exp_';
            ee()->load->library('session');
            $name = $prefix.ee()->session->c_session;

            // Session ID can come from get request or cookie
            if (ee()->config->item('website_session_type') ?? null == 's') {
                $id = (ee()->input->get('S')) ? ee()->input->get('S') : ee()->uri->session_id;
            }
            // Most often we'll be relying on the cookie though
            if (empty($id)) {
                $id = ee()->input->cookie(ee()->session->c_session);
            }

            // $handler = new \Expressionengine\Coilpack\Session\CookieSessionHandler($app->make('cookie'), 60);
            $handler = new \Expressionengine\Coilpack\Session\DatabaseSessionHandler(
                $app->make('db')->connection('coilpack'), 'sessions', 60, $app
            );

            $session = new \Illuminate\Session\Store($name, $handler, $id);
            $session->start(); // This is usually handled in middleware
            $provider = $app->make('auth')->createUserProvider($config['provider'] ?? null);

            return new \Expressionengine\Coilpack\Auth\SessionGuard($name, $provider, $session);
        });

        // Configure our 'coilpack' guard which uses the 'members' provider below
        app('config')->set('auth.guards.coilpack', [
            'driver' => 'exp_sessions',
            'provider' => 'coilpack',
        ]);

        app('config')->set('auth.providers.coilpack', [
            'driver' => 'coilpack',
            'model' => $this->getMemberModel(),
        ]);

        try {
            $this->registerGateDefinitions();
        } catch (\Illuminate\Database\QueryException $e) {
        }
    }

    protected function getMemberModel()
    {
        $model = \Expressionengine\Coilpack\Models\Member\Member::class;

        return app('config')->get('coilpack.member_model', $model) ?? $model;
    }

    protected function registerGateDefinitions()
    {
        Permission::query()
            ->selectRaw('permission, GROUP_CONCAT(role_id) AS role_ids')
            ->groupBy('permission')
            ->each(function ($permission) {
                Gate::define("ee:{$permission->permission}", function ($user) use ($permission) {
                    $permissionRoles = explode(',', $permission->role_ids);
                    $model = $this->getMemberModel();

                    if (! $user instanceof $model) {
                        return false;
                    }

                    return ! empty(array_intersect($permissionRoles, $user->roles->pluck('role_id')->toArray()));
                });
            });
    }
}
