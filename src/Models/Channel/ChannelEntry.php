<?php

namespace Expressionengine\Coilpack\Models\Channel;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Model;
use Expressionengine\Coilpack\Models\Category\Category;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Models\Member\Member;

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

    protected $casts = [
        'versioning_enabled' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'allow_comments' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'sticky' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        // 'entry_date' => 'integer',
        'expiration_date' => 'integer',
        'comment_expiration_date' => 'integer',
        'author_id' => 'integer',
        'edit_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'entry_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
        'recent_comment_date' => \Expressionengine\Coilpack\Casts\UnixTimestamp::class,
    ];

    protected static $_relationships = [
        'Channel' => [
            'type' => 'belongsTo',
            'key' => 'channel_id',
        ],
        'Author' => [
            'type' => 'belongsTo',
            'model' => 'Member',
            'from_key' => 'author_id',
        ],
        'Status' => [
            'type' => 'belongsTo',
            'weak' => true,
        ],
        'Categories' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Category',
            'pivot' => [
                'table' => 'category_posts',
                'left' => 'entry_id',
                'right' => 'cat_id',
            ],
        ],
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

        // If this field is not storing it's data on the channel_data table we
        // will join the separate data table with a unique orderby_field_name alias
        if ($field->legacy_field_data == 'n' || $field->legacy_field_data === false) {
            $alias = "orderby_{$field->field_name}";
            $column = "$alias.$column";
            $this->scopeJoinFieldDataTable($query, $field, $alias);
        }

        return $query->orderBy($column, $direction);
    }

    public function scopeJoinFieldDataTable($query, $field, $alias = null)
    {
        if ($field->legacy_field_data == 'y' || $field->legacy_field_data === true) {
            return $query;
        }

        $table = $field->data_table_name;
        $joinTable = $alias ? "$table as $alias" : $table;
        $alias = $alias ?: $table;
        $query->leftJoin($joinTable, "$alias.entry_id", '=', $this->qualifyColumn('entry_id'));
        $query->select('*', $this->qualifyColumn('entry_id'));

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
        return $this->belongsToMany(ChannelField::class,
            'channel_entry_hidden_fields', 'entry_id', 'field_id');
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
            $fields = $this->data->fields($this->channel);
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
}
