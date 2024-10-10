<?php

namespace Expressionengine\Coilpack;

use Illuminate\Contracts\Support\Arrayable;

class TemplateOutput implements \ArrayAccess, \Countable, \IteratorAggregate, \Stringable
{
    protected $array = [];

    protected $string = '';

    protected $object = null;

    public static function make()
    {
        return new static;
    }

    public function value($value)
    {
        if (is_object($value)) {
            $this->object = $value;
        }

        if (is_array($value) || $value instanceof Arrayable) {
            $this->array(is_array($value) ? $value : $value->toArray());
        } else {
            $this->string(is_string($value) ? $value : (string) $value);
        }

        return $this;
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

    public function object($value)
    {
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
        // If we have an object set and it is iterable we will prefer to use that
        if ($this->object && method_exists($this->object, 'getIterator')) {
            return $this->object->getIterator();
        }

        if (is_object($this->array) && method_exists($this->array, 'getIterator')) {
            return $this->array->getIterator();
        }

        return new \ArrayIterator($this->array);
    }

    public function count(): int
    {
        if (! is_null($this->object) && method_exists($this->object, 'getIterator')) {
            return iterator_count($this->object->getIterator());
        }

        if (! empty($this->array)) {
            return count($this->array);
        }

        return strlen($this->string);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
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
    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
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
     */
    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
    }

    public function __toString(): string
    {
        if (empty($this->string) && count($this->array) === 1 && is_string(current($this->array))) {
            return current($this->array);
        }

        return (string) $this->string;
    }

    public function __get($key)
    {
        if ($this->object && property_exists($this->object, $key)) {
            return $this->object->$key;
        }

        if (array_key_exists($key, (array) $this->array)) {
            return $this->array[$key];
        }

        return null;
    }

    public function __isset($key)
    {
        return ($this->object && property_exists($this->object, $key)) || array_key_exists($key, (array) $this->array);
    }

    public function __call($method, $arguments)
    {
        return $this->object ? $this->object->{$method}(...$arguments) : null;
    }
}
