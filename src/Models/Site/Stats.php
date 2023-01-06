<?php

namespace Expressionengine\Coilpack\Models\Site;

use Expressionengine\Coilpack\Model;

/**
 * Stats Model
 */
class Stats extends Model
{
    protected $primaryKey = 'stat_id';

    protected $table = 'stats';

    protected static $_relationships = [
        'Site' => [
            'type' => 'BelongsTo',
        ],
        'RecentMember' => [
            'type' => 'BelongsTo',
            'model' => 'Member',
            'from_key' => 'recent_member_id',
            'weak' => true,
        ],
    ];
}
