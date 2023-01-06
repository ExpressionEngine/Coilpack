<?php

namespace Expressionengine\Coilpack\Models\Addon;

use Expressionengine\Coilpack\Model;

/**
 * Fieldtype Model
 */
class Fieldtype extends Model
{
    protected $primaryKey = 'fieldtype_id';

    protected $table = 'fieldtypes';

    protected $casts = [
        'has_global_settings' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'settings' => 'base64Serialized',
    ];
}
