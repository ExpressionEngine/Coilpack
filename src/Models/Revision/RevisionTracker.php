<?php

namespace Expressionengine\Coilpack\Models\Revision;

use Expressionengine\Coilpack\Model;

/**
 * Revision Tracker Model
 */
class RevisionTracker extends Model
{
    protected $primaryKey = 'tracker_id';

    protected $table = 'revision_tracker';

    protected $casts = [
        'tracker_id' => 'integer',
        'item_id' => 'integer',
        'item_date' => 'integer',
        'item_author_id' => 'integer',
    ];

    protected static $_relationships = [
        'Template' => [
            'type' => 'BelongsTo',
            'from_key' => 'item_id',
        ],
        'Author' => [
            'type' => 'belongsTo',
            'model' => 'Member',
            'from_key' => 'item_author_id',
            'weak' => true,
        ],
    ];
}
