<?php

namespace Expressionengine\Coilpack\Dependency;

use ExpressionEngine\Core\Provider;
use ExpressionEngine\Service\View\StubFactory as Factory;

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

        // The path at index 0 is the user override path which we still want to be the highest priority
        array_splice($paths, 1, 0, [
            $basePath.'/fieldtypes/'.$provider->getPrefix().($generatorFolder ? "/$generatorFolder" : ''),
            $basePath.'/fieldtypes',
            $basePath.'/templates/'.$provider->getPrefix().($generatorFolder ? "/$generatorFolder" : ''),
            $basePath.'/templates',
        ]);

        return $paths;
    }
}
