<?php


namespace Expressionengine\Coilpack\Models\Comment;

use Expressionengine\Coilpack\Model;

/**
 * Comment Subscription Model
 *
 * A model representing user subscriptions to the comment thread on a particular
 * entry.
 */
class CommentSubscription extends Model
{
    protected $primaryKey = 'subscription_id';
    protected $table = 'comment_subscriptions';

    public function entry()
    {
        return $this->belongsTo(ChannelEntry::class, 'entry_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

}


