<?php

namespace Expressionengine\Coilpack\Dependency;

use Expressionengine\Coilpack\Traits\CanAccessRestrictedClass;
use ExpressionEngine\Service\Dependency\InjectionContainer;

class Container extends InjectionContainer
{
    use CanAccessRestrictedClass;

    public function useContainer(InjectionContainer $container)
    {
        $this->registry = $this->getRestrictedProperty($container, 'registry');
        $this->singletonRegistry = $this->getRestrictedProperty($container, 'singletonRegistry');

        return $this;
    }

    /**
     * Registers a dependency with the container
     *
     * @param  string  $name  The name of the dependency in the form
     *                        Vendor:Namespace
     * @param  Closure|obj  $object  The object to use
     * @return self Returns this InjectionContainer object
     */
    public function overwrite($name, $object)
    {
        if (strpos($name, ':') === false) {
            $name = static::NATIVE_PREFIX.$name;
        }

        if($this->has($name)) {
            $this->registry[$name] = (is_callable($object)) ? $object() : $object;
        }

        return $this;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->registry);
    }
}
