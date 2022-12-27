<?php


namespace Expressionengine\Coilpack\Models\Consent;

use Expressionengine\Coilpack\Model;

/**
 * Consent Request Model
 */
class ConsentRequest extends Model
{
    protected $primaryKey = 'consent_request_id';
    protected $table = 'consent_requests';

    protected $casts = [
        'consent_request_id' => 'integer',
        'consent_request_version_id' => 'integer',
        'double_opt_in' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'user_created' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];

    protected static $_relationships = [
        'CurrentVersion' => [
            'type' => 'belongsTo',
            'model' => 'ConsentRequestVersion',
            'from_key' => 'consent_request_version_id'
        ],
        'Versions' => [
            'type' => 'hasMany',
            'model' => 'ConsentRequestVersion'
        ],
        'Consents' => [
            'type' => 'hasMany',
            'model' => 'Consent'
        ],
        'Logs' => [
            'type' => 'hasMany',
            'model' => 'ConsentAuditLog'
        ],
    ];

}


