<?php

namespace Expressionengine\Coilpack;

use ArrayIterator;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

class FieldtypeOutput implements \IteratorAggregate, \ArrayAccess
{
    protected $array = [];
    protected $string = '';
    protected $object = null;

    public static function make($value)
    {
        $instance = new static;

        if(is_object($value)) {
            $instance->object = $value;
        }

        if(is_array($value) || $value instanceof Arrayable) {
            $instance->array(is_array($value) ? $value : $value->toArray());
        }else{
            $instance->string(is_string($value) ? $value : (string) $value);
        }

        return $instance;
    }

    public function string($value)
    {
        $this->string = $value;

        return $this;
    }

    public function array($value)
    {
        $this->array = $value;

        return $this;
    }

    public function object($value) {
        $this->object = $value;

        return $this;
    }

    public function toArray()
    {
        return $this->array;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function getIterator(): \Traversable
    {
        if(is_object($this->array) && method_exists($this->array, 'getIterator')) {
            return $this->array->getIterator();
        }

        return new \ArrayIterator($this->array);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
    }

    public function __toString()
    {
        if (empty($this->string) && count($this->array) === 1 && is_string(current($this->array))) {
            return current($this->array);
        }

        return (string) $this->string;
    }

    public function __get($key)
    {
        if(array_key_exists($key, (array) $this->array)) {
            return $this->array[$key];
        }

        return null;
    }

    public function __isset($key)
    {
        return array_key_exists($key, (array) $this->array);
    }

    public function __call($method, $arguments) {
        return $this->object->{$method}(...$arguments);
    }


}
