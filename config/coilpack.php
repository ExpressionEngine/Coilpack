<?php

return [
    /**
     * Path to ExpressionEngine folder where admin.php and index.php live
     * Can be absolute or relative from your Laravel project
     */
    'base_path' => './ee',

    /**
     * Path to ExpressionEngine's system folder. Relative from base_path
     */
    'system_path' => 'system',

    /**
     * Path to ExpressionEngine's config folder. Relative from base_path
     */
    'config_path' => 'system/user/config',

    /**
     * URL to access the ExpressionEngine control panel
     */
    'admin_url' => 'admin.php',

    /**
     * If you wish to provide your own implementation of the Member model
     * you may specify that here.  Keep in mind that it may be helpful
     * to extend our existing Member model for easier integration.
     */
    'member_model' => null,

    /**
     * Placeholder for config values read from ExpressionEngine install
     */
    'expressionengine' => [

    ],
];
