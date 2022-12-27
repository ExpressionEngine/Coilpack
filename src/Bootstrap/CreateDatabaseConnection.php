<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;


class CreateDatabaseConnection
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (!$config = config('coilpack.expressionengine.database')) {
            // throw new \Exception('ExpressionEngine database configuration missing.');
            $config = [];
        }

        $config = (array_key_exists('expressionengine', $config)) ? $config['expressionengine'] : $config;

        app('config')->set('database.connections.coilpack', [
            'driver' => 'mysql',
            'url' => '',
            'host' => $config['hostname'] ?? env('DB_HOST', '127.0.0.1'),
            'port' => $config['port'] ?? env('DB_PORT', '3306'),
            'database' => $config['database'] ?? env('EE_DB_DATABASE', 'expressionengine'),
            'username' => $config['username'] ?? env('DB_USERNAME', 'forge'),
            'password' => $config['password'] ?? env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => $config['char_set'] ?? 'utf8mb4',
            'collation' => $config['dbcollat'] ?? 'utf8mb4_unicode_ci',
            'prefix' => $config['dbprefix'] ?? 'exp_',
            // 'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]);
    }
}
