<?php
/**
 * This source file is part of the open source project
 * ExpressionEngine (https://expressionengine.com)
 *
 * @link      https://expressionengine.com/
 *
 * @copyright Copyright (c) 2003-2020, Packet Tide, LLC (https://www.packettide.com)
 * @license   https://expressionengine.com/license Licensed under Apache License, Version 2.0
 */

namespace Expressionengine\Coilpack\Models\Cookie;

use Expressionengine\Coilpack\Model;

/**
 * Cookie Settings Model
 */
class CookieSetting extends Model
{
    protected $primaryKey = 'cookie_id';

    protected $table = 'cookie_settings';

    protected $casts = [
        'cookie_id' => 'integer',
        'cookie_provider' => 'string',
        'cookie_name' => 'string',
        'cookie_title' => 'string',
        'cookie_description' => 'string',
    ];

    protected static $_relationships = [
        'ConsentRequestVersion' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'ConsentRequestVersion',
            'pivot' => [
                'table' => 'consent_request_version_cookies',
            ],
        ],
    ];
}
