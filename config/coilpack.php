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
     * Settings to control the behavior of the built-in GraphQL integration
     */
    'graphql' => [
        /**
         * Flag to enable the GraphQL API route at /graphql
         */
        'enabled' => env('COILPACK_GRAPHQL_ENABLED', false),

        /**
         * Flag to enable the Graphiql interactive GraphQL explorer at /graphiql
         * Note that in order to use this tool you must also enable graphql above
         */
        'graphiql' => env('COILPACK_GRAPHIQL_ENABLED', false),

        /**
         * Flag to set the 'coilpack' schema as your default schema
         */
        'is_default_schema' => true,

        /**
         * Settings to control how requests to the GraphQL API should be authenticated
         */
        'auth' => [
            /**
             * Flag to control whether or not authentication is enabled
             */
            'enabled' => env('COILPACK_GRAPHQL_AUTH_ENABLED', true),

            /**
             * The driver that should be used for authenticating requests
             *
             * Supported drivers: 'token'
             */
            'driver' => env('COILPACK_GRAPHQL_AUTH_DRIVER', 'token'),

            /**
             * When using the 'token' driver it will be stored here
             */
            'token' => env('COILPACK_GRAPHQL_TOKEN', null),
        ],
    ],

    /**
     * Placeholder for config values read from ExpressionEngine install
     */
    'expressionengine' => [

    ],
];
