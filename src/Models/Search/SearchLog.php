<?php


namespace Expressionengine\Coilpack\Models\Search;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Member\Member;

/**
 * Search Log Model
 */
class SearchLog extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'search_log';

    protected static $_relationships = array(
        'Site' => array(
            'type' => 'BelongsTo'
        ),
        'Member' => array(
            'type' => 'BelongsTo'
        )
    );

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

}


