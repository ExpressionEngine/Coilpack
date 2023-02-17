<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['debug'] = 2;
$config['index_page'] = '';
$config['enable_devlog_alerts'] = 'n';
$config['require_cookie_consent'] = 'n';
$config['ignore_member_stats'] = 'y';
// ExpressionEngine Config Items
// Find more configs and overrides at
// https://docs.expressionengine.com/latest/general/system_configuration_overrides.html
$config['save_tmpl_files'] = 'y';
$config['base_path'] = $_SERVER['DOCUMENT_ROOT'] ?? realpath(__DIR__.'../../../../');
$config['base_url'] = $_ENV['APP_URL'] ?? 'http://127.0.0.1:8001/';
$config['site_url'] = $config['base_url'];
$config['site_index'] = '';
$config['database'] = [
    'expressionengine' => [
        'hostname' => $_ENV['DB_HOST'] ?? 'localhost',
        'database' => $_ENV['EE_DB_DATABASE'] ?? 'coilpack',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'dbprefix' => 'exp_',
        'char_set' => 'utf8mb4',
        'dbcollat' => 'utf8mb4_unicode_ci',
        'port' => '',
    ],
];

// EOF
