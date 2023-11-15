<?php

namespace Expressionengine\Coilpack\Traits;

trait CanAccessRestrictedClass
{
    protected function getRestrictedProperty($object, $property)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue($object);
    }

    protected function setRestrictedProperty($object, $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setValue($object, $value);
    }

    public function callRestrictedMethod($object, $method, $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invoke($object, ...$parameters);
    }
}
