<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Category\Category;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\Member\Member;
use Illuminate\Support\Str;

/**
 * Channel Entry
 *
 * An entry in a content channel.  May have multiple custom fields in
 * addition to a number of built in fields.  Is content and may be
 * rendered on the front end.  Has a publish form that includes its
 * many fields as sub publish elements.
 *
 * Related to Channel which defines the structure of this content.
 */
class ChannelEntry extends Model
{
    protected $primaryKey = 'entry_id';

    protected $table = 'channel_titles';

    protected $isPreview = false;

    protected $casts = [
        'versioning_enabled' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'allow_comments' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'sticky' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'expiration_date' => 'integer',
        'comment_expiration_date' => 'integer',
        'author_id' => 'integer',
        'edit_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'entry_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'recent_comment_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
    ];

    protected static $_relationships = [
        'Autosaves' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntryAutosave',
            'to_key' => 'original_entry_id',
        ],
        'Parents' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'ChannelEntry',
            'pivot' => [
                'table' => 'relationships',
                'left' => 'child_id',
                'right' => 'parent_id',
            ],
        ],
        'Children' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'ChannelEntry',
            'pivot' => [
                'table' => 'relationships',
                'left' => 'parent_id',
                'right' => 'child_id',
            ],
        ],
        'Versions' => [
            'type' => 'hasMany',
            'model' => 'ChannelEntryVersion',
        ],
        'Comments' => [
            'type' => 'hasMany',
            'model' => 'Comment',
        ],
        'CommentSubscriptions' => [
            'type' => 'hasMany',
            'model' => 'CommentSubscription',
        ],
        'Site' => [
            'type' => 'belongsTo',
        ],
    ];

    protected static $_field_data = [
        'field_model' => 'ChannelField',
        'group_column' => 'channel_id',
        'structure_model' => 'Channel',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new Scopes\HideExpired);
        static::addGlobalScope(new Scopes\HideFuture);
    }

    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'entry_id', 'cat_id');
    }

    public function data()
    {
        $manager = app(FieldtypeManager::class);
        $fields = $manager->fieldsForChannel(($this->exists && $this->channel) ? $this->channel : null);
        $fields = (! $fields->isEmpty()) ? $fields : $manager->allFields('channel');

        return $this->hasOne(ChannelData::class, 'entry_id', 'entry_id')->customFields($fields);
    }

    public function scopeOrderByCustomField($query, $field, $direction = 'asc')
    {
        $manager = app(FieldtypeManager::class);

        if (! $manager->hasField($field)) {
            return $query;
        }

        $field = $manager->getField($field);
        $column = "field_id_{$field->field_id}";

        // Setup our join for the appropriate channel data table and alias
        $alias = $field->hasLegacyFieldData() ? 'orderby_legacy_data' : "orderby_{$field->field_name}";
        $this->scopeJoinFieldDataTable($query, $field, $alias);
        $query->select($this->qualifyColumn('*'));

        return $query->orderBy("$alias.$column", $direction);
    }

    public function scopeJoinFieldDataTable($query, $field, $alias = null)
    {
        // If we have already joined this table alias just do nothing
        $alreadyJoined = collect($query->getQuery()->joins)->pluck('table')->contains(function ($joinTable) use ($alias) {
            return strpos($joinTable, $alias) !== false;
        });

        if ($alreadyJoined) {
            return $query;
        }

        $table = $field->hasLegacyFieldData() ? (new ChannelData)->getTable() : $field->data_table_name;
        $joinTable = $alias ? "$table as $alias" : $table;
        $alias = $alias ?: $table;
        $query->leftJoin($joinTable, "$alias.entry_id", '=', $this->qualifyColumn('entry_id'));
        $query->select($this->qualifyColumn('*'));

        return $query;
    }

    public function fluidData()
    {
        return $this->hasMany(Addon\Fluid\Data::class, 'entry_id');
    }

    public function fields()
    {
        return $this->hasManyThrough(ChannelField::class, Channel::class);
    }

    public function hiddenFields()
    {
        return $this->belongsToMany(
            ChannelField::class,
            'channel_entry_hidden_fields',
            'entry_id',
            'field_id'
        );
    }

    public function grids()
    {
    }

    public function parents()
    {
    }

    public function children()
    {
        $this->belongsToMany(static::class, 'relationships', 'parent_id', 'child_id');
    }

    public function siblings()
    {
        // $this->parents()->children();
    }

    public function relationships()
    {
        return null;
    }

    public function getPageUriAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Add page data to channel entries after the query
        $pages = ee()->config->site_pages($this->site_id)[$this->site_id];

        if ($pages && isset($pages['uris'][$this->entry_id])) {
            return $pages['uris'][$this->entry_id];
        }

        return '';
    }

    public function getPageUrlAttribute($value)
    {
        $siteUrl = ee()->config->site_pages($this->site_id)[$this->site_id]['url'] ?? '';

        return ee()->functions->create_page_url($siteUrl, $this->page_uri);
    }

    public function __get($key)
    {
        // First we check if the model actually has a value for this attribute
        $value = parent::__get($key);

        // If we're trying to get a $key that corresponds to a Field::$field_name
        // we will forward the check to the entry's data

        // $fields = Field::select('field_name')->get()->keyBy('field_name');
        // if(is_null($value) && $fields->has($key)) {
        if (is_null($value) && app(FieldtypeManager::class)->hasField($key)) {
            $this->getRelationValue('data');
            $fields = $this->data->fields($this);
            $value = ($fields->has($key)) ? $fields->get($key) : new FieldContent([
                'field' => app(FieldtypeManager::class)->getField($key),
                'data' => null,
                'entry' => $this,
                'entry_id' => $this->entry_id,
                'site_id' => $this->site_id,
                'channel_id' => $this->channel_id,
            ]);

            // $value->setAttribute('data', 'null');
        }

        return $value;
    }

    public function fillWithEntryData($data)
    {
        // Split out field data beginning with `field_`
        [$fieldData, $attributes] = collect($data)->partition(function ($item, $key) {
            return Str::startsWith($key, 'field_');
        });

        $this->forceFill($attributes->toArray());
        $channelData = (new ChannelData)->forceFill($fieldData->toArray());
        $channelData->entry_id = $data['entry_id'];
        $channelData->setRelation('fields', ChannelField::all());
        $this->setRelation('data', $channelData);

        return $this;
    }

    public function markAsPreview()
    {
        $this->isPreview = true;

        return $this;
    }

    public function isPreview()
    {
        return $this->isPreview;
    }
}
