<?php

namespace Expressionengine\Coilpack\Models\Addon;

use Expressionengine\Coilpack\Model;

/**
 * Extension Model
 */
class Extension extends Model
{
    protected $primaryKey = 'extension_id';

    protected $table = 'extensions';

    protected static $_validation_rules = [
        'csrf_exempt' => 'enum[y,n]',
    ];

    protected $casts = [
        'enabled' => \Expressionengine\Coilpack\Casts\BooleanString::class,
        'settings' => \Expressionengine\Coilpack\Casts\Serialize::class,
    ];

    /**
     * Marks the Extension as enabled
     */
    public function enable()
    {
        $this->enabled = 'y';
    }

    /**
     * Marks the Extension as disabled
     */
    public function disable()
    {
        $this->enabled = 'n';
    }
}
