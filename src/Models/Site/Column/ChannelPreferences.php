<?php

namespace Expressionengine\Coilpack\Models\Site\Column;

use ExpressionEngine\Service\Model\Column\CustomType;
use ExpressionEngine\Service\Model\Column\Serialized\Base64Native;

/**
 * Channel Preferences Column
 */
class ChannelPreferences extends CustomType
{
    protected $auto_assign_cat_parents;

    protected $auto_convert_high_ascii;

    protected $comment_edit_time_limit;

    protected $comment_moderation_override;

    protected $comment_word_censoring;

    protected $enable_comments;

    protected $image_library_path;

    protected $image_resize_protocol;

    protected $new_posts_clear_caches;

    protected $reserved_category_word;

    protected $thumbnail_prefix;

    protected $use_category_name;

    protected $word_separator;

    /**
     * Called when the column is fetched from db
     */
    public function unserialize($db_data)
    {
        return Base64Native::unserialize($db_data);
    }

    /**
     * Called before the column is written to the db
     */
    public function serialize($data)
    {
        return Base64Native::serialize($data);
    }
}
