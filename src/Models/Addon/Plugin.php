<?php

namespace Expressionengine\Coilpack\Models\Addon;

use Expressionengine\Coilpack\Model;

/**
 * Plugin Model
 */
class Plugin extends Model
{
    protected $primaryKey = 'plugin_id';

    protected $table = 'plugins';

    protected $casts = [
        'is_typography_related' => \Expressionengine\Coilpack\Casts\BooleanString::class,
    ];
}
