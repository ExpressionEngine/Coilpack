<?php

namespace Expressionengine\Coilpack\Models\File;

use Expressionengine\Coilpack\Model;

/**
 * File Dimension Model
 *
 * A model representing one of image manipulations that can be applied on
 * images uploaded to its corresponting upload destination.
 */
class FileDimension extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'file_dimensions';

    protected $casts = [
        //'width'  => 'integer',
        //'height' => 'integer'
        'quality' => 'integer',
    ];

    protected static $_relationships = [
        'UploadDestination' => [
            'type' => 'belongsTo',
            'from_key' => 'upload_location_id',
        ],
        'Watermark' => [
            'type' => 'hasOne',
            'from_key' => 'watermark_id',
            'to_key' => 'wm_id',
        ],
    ];
}
