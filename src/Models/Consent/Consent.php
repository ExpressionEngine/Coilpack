<?php

namespace Expressionengine\Coilpack\Models\Consent;

use Expressionengine\Coilpack\Model;

/**
 * Consent Model
 */
class Consent extends Model
{
    protected $primaryKey = 'consent_id';

    protected $table = 'consents';

    protected $casts = [
        'consent_id' => 'integer',
        'consent_request_id' => 'integer',
        'consent_request_version_id' => 'integer',
        'member_id' => 'integer',
        'consent_given' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'expiration_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'response_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
    ];

    protected static $_relationships = [
        'ConsentRequest' => [
            'type' => 'belongsTo',
        ],
        'ConsentRequestVersion' => [
            'type' => 'belongsTo',
        ],
        'Member' => [
            'type' => 'belongsTo',
        ],
    ];
}
