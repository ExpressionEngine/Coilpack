<?php


namespace Expressionengine\Coilpack\Models\Comment;

use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Channel\ChannelEntry;

/**
 * Comment Model
 *
 * A model representing a comment on a Channel entry.
 */
class Comment extends Model
{
    protected $primaryKey = 'comment_id';
    protected $table = 'comments';

    protected static $_hook_id = 'comment';

    public function entry()
    {
        return $this->belongsTo(ChannelEntry::class, 'entry_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function author()
    {
        return $this->belongsTo(Member::class, 'member_id', 'author_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }


}


