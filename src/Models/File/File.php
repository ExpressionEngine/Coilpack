<?php

namespace Expressionengine\Coilpack\Models\File;

use Expressionengine\Coilpack\Model;

/**
 * File Model
 *
 * A model representing one of many possible upload destintations to which
 * files may be uploaded through the file manager or from the publish page.
 * Contains settings for this upload destination which describe what type of
 * files may be uploaded to it, as well as essential information, such as the
 * server paths where those files actually end up.
 */
class File extends Model
{
    protected $primaryKey = 'file_id';

    protected $table = 'files';

    protected static $_relationships = [
        'Site' => [
            'type' => 'belongsTo',
        ],
        'UploadDestination' => [
            'type' => 'belongsTo',
            'to_key' => 'id',
            'from_key' => 'upload_location_id',
        ],
        'UploadAuthor' => [
            'type' => 'BelongsTo',
            'model' => 'Member',
            'from_key' => 'uploaded_by_member_id',
        ],
        'ModifyAuthor' => [
            'type' => 'BelongsTo',
            'model' => 'Member',
            'from_key' => 'modified_by_member_id',
        ],
        'Categories' => [
            'type' => 'hasAndBelongsToMany',
            'model' => 'Category',
            'pivot' => [
                'table' => 'file_categories',
                'left' => 'file_id',
                'right' => 'cat_id',
            ],
        ],
    ];
}
