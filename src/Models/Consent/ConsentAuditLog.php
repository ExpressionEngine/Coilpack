<?php


namespace Expressionengine\Coilpack\Models\Consent;

use Expressionengine\Coilpack\Model;

/**
 * Consent Audit Log Model
 */
class ConsentAuditLog extends Model
{
    protected $primaryKey = 'consent_audit_id';
    protected $table = 'consent_audit_log';

    protected $casts = [
        'consent_audit_id' => 'integer',
        'consent_request_id' => 'integer',
        'consent_request_version_id' => 'integer',
        'member_id' => 'integer',
        'log_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
    ];

    protected static $_relationships = [
        'ConsentRequest' => [
            'type' => 'belongsTo'
        ],
        'ConsentRequestVersion' => [
            'type' => 'belongsTo'
        ],
        'Member' => [
            'type' => 'belongsTo'
        ]
    ];

}


