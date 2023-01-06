<?php

namespace Expressionengine\Coilpack\Models\Consent;

use Expressionengine\Coilpack\Model;

/**
 * Consent Request Version Model
 */
class ConsentRequestVersion extends Model
{
    protected $primaryKey = 'consent_request_version_id';

    protected $table = 'consent_request_versions';

    protected $casts = [
        'consent_request_version_id' => 'integer',
        'consent_request_id' => 'integer',
        'create_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'author_id' => 'integer',
    ];

    protected static $_relationships = [
        'ConsentRequest' => [
            'type' => 'belongsTo',
        ],
        'CurrentVersion' => [
            'type' => 'belongsTo',
            'model' => 'ConsentRequest',
            'to_key' => 'consent_request_version_id',
        ],
        'Consents' => [
            'type' => 'hasMany',
            'model' => 'Consent',
        ],
        'Author' => [
            'type' => 'belongsTo',
            'model' => 'Member',
            'from_key' => 'author_id',
            'weak' => true,
        ],
        'Logs' => [
            'type' => 'hasMany',
            'model' => 'ConsentAuditLog',
        ],
        'Cookies' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'CookieSetting',
            'pivot' => [
                'table' => 'consent_request_version_cookies',
            ],
        ],
    ];
}
