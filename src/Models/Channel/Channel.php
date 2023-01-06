<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\Model;

/**
 * Channel Model
 */
class Channel extends Model
{
    protected $primaryKey = 'channel_id';

    protected $table = 'channels';

    // Properties
    protected $attributes = [
        'deft_status' => 'open',
        'deft_comments' => true,
        'channel_require_membership' => true,
        'channel_html_formatting' => 'all',
        'channel_allow_img_urls' => true,
        'channel_auto_link_urls' => false,
        'channel_notify' => false,
        'sticky_enabled' => false,
        'comment_system_enabled' => true,
        'comment_require_membership' => false,
        'comment_moderate' => false,
        'comment_max_chars' => 5000,
        'comment_timelock' => 0,
        'comment_require_email' => true,
        'comment_text_formatting' => 'xhtml',
        'comment_html_formatting' => 'safe',
        'comment_allow_img_urls' => false,
        'comment_auto_link_urls' => true,
        'comment_notify' => false,
        'comment_notify_authors' => false,
        'enable_versioning' => false,
        'max_revisions' => 10,
        'allow_preview' => true,
    ];

    protected $casts = [
        'deft_comments' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'channel_require_membership' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'channel_allow_img_urls' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'channel_auto_link_urls' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'channel_notify' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'sticky_enabled' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_system_enabled' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_require_membership' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_moderate' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_require_email' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_allow_img_urls' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_auto_link_urls' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_notify' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'comment_notify_authors' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'enable_versioning' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'search_excerpt' => 'integer',
    ];

    public function fieldGroups()
    {
        return $this->belongsToMany(ChannelFieldGroup::class, 'channels_channel_field_groups', 'channel_id', 'group_id', 'channel_id', 'group_id');
    }

    public function allFields()
    {
        if (! $this->exists) {
            return ChannelField::all()->keyBy('field_id');
        }

        return $this->fields->merge($this->fieldGroups->flatMap(function ($group) {
            return $group->fields;
        }))->keyBy('field_id');
    }

    public function fields()
    {
        return $this->belongsToMany(ChannelField::class, 'channels_channel_fields', 'channel_id', 'field_id', 'channel_id', 'field_id');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class, 'channels_statuses');
    }

    public function customFields()
    {
        return $this->hasMany(ChannelField::class, 'channels_channel_fields');
    }

    public function entries()
    {
        return $this->hasMany(ChannelEntry::class, 'channel_id', 'channel_id');
    }
}
