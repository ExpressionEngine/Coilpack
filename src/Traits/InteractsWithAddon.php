<?php

namespace Expressionengine\Coilpack\Traits;

trait InteractsWithAddon
{
    public function getAddonInstance($addon)
    {
        $addonClass = '\\'.\ee('Addon')->get($addon)->getFrontendClass();

        return new $addonClass;
    }

    public function getAddonModuleInstance($addon)
    {
        $module = '\\'.ltrim(\ee('Addon')->get($addon)->getModuleClass(), '\\');

        return new $module;
    }
}
