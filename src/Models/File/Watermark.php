<?php

namespace Expressionengine\Coilpack\Models\File;

use Expressionengine\Coilpack\Model;

/**
 * Watermark Model
 *
 * A model representing one of the watermarks associated with an image
 * manipulation belonging to an upload destination
 */
class Watermark extends Model
{
    protected $primaryKey = 'wm_id';

    protected $table = 'file_watermarks';

    protected $casts = [
        'wm_use_font' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'wm_use_drop_shadow' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        //'wm_font_size'       => 'integer',
        //'wm_padding'         => 'integer',
        //'wm_opacity'         => 'integer',
        //'wm_hor_offset'      => 'integer',
        //'wm_vrt_offset'      => 'integer',
        //'wm_x_transp'        => 'integer',
        //'wm_y_transp'        => 'integer',
        //'wm_shadow_distance' => 'integer'
    ];

    protected static $_relationships = [
        'FileDimension' => [
            'type' => 'belongsTo',
            'from_key' => 'wm_id',
            'to_key' => 'watermark_id',
        ],
    ];
}
