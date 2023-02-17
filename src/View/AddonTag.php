<?php

namespace Expressionengine\Coilpack\View;

class AddonTag extends LegacyTag
{
    protected $signature;

    protected $addon;

    public function __construct()
    {
        $pieces = explode(':', $this->signature);
        $this->addon = $pieces[0];
        $this->method = $pieces[1];
        $this->instance = ee('Addon')->get($this->addon);
    }
}
