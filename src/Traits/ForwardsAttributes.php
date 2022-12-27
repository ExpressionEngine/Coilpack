<?php

namespace Expressionengine\Coilpack\Traits;

use BadMethodCallException;
use Error;

trait ForwardsAttributes
{
    /**
     * Forward a method call to the given object.
     *
     * @param  mixed  $object
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    protected function forwardAttributeTo($object, $attribute, $deep = true)
    {
        try {
            $value = $object->{$attribute};
            $usingTrait = in_array(static::class, class_uses($object));
            return $value;
        } catch (Error | BadMethodCallException $e) {
            return null;
        }
    }

}
