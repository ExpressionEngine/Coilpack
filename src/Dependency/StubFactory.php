<?php

namespace Expressionengine\Coilpack\Dependency;

use ExpressionEngine\Core\Provider;
use ExpressionEngine\Service\View\StubFactory as Factory;
use Illuminate\Support\Str;

class StubFactory extends Factory
{
    // use CanAccessRestrictedClass;

    /**
     * Get the array of stub paths
     * This would include:
     * - user folder
     * - add-on folder
     * - theming add-on folder
     * - shared stubs folder
     *
     *
     * @return array
     */
    public function getGeneratorStubPaths(Provider $provider, string $generatorFolder, $theme = null)
    {
        $paths = parent::getGeneratorStubPaths($provider, $generatorFolder, $theme);

        $basePath = realpath(__DIR__.'/../../resources/stubs');
        // The path at index 0 is the user override path which should always be the highest priority
        // If the path at index 1 is a user addon it should also take priority over our overrides
        $offset = Str::contains($paths[1], 'system/user/addons') ? 2 : 1;

        array_splice($paths, $offset, 0, [
            $basePath.'/fieldtypes/'.$provider->getPrefix().($generatorFolder ? "/$generatorFolder" : ''),
            $basePath.'/fieldtypes',
            $basePath.'/templates/'.$provider->getPrefix().($generatorFolder ? "/$generatorFolder" : ''),
            $basePath.'/templates',
        ]);

        return $paths;
    }
}
