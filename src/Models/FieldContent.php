<?php

namespace Expressionengine\Coilpack\Models;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;

class FieldContent implements Jsonable, \IteratorAggregate, \ArrayAccess
{
    use HasAttributes, HidesAttributes, HasRelationships;

    /**
     * Create a new model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->syncOriginal();

        $this->setRawAttributes($attributes);
    }

    public function getDataAttribute($value)
    {
        return $value;
    }

    public function getFieldtype()
    {
        if (isset($this->attributes['fieldtype'])) {
            return $this->fieldtype;
        }

        $this->attributes['fieldtype'] = $this->field->getFieldtype();

        return $this->fieldtype;
    }

    public function value($parameters = [])
    {
        // should hash and cache params too
        if (empty($parameters) && array_key_exists('value', $this->attributes)) {
            return $this->attributes['value'];
        }

        $fieldtype = $this->getFieldtype();

        $value = $fieldtype->apply($this, $parameters);
        if (empty($parameters)) {
            $this->attributes['value'] = $value;
        }

        return $value;
    }

    public function callModifier($name, $parameters = [])
    {
        $fieldtype = $this->getFieldtype();

        return $fieldtype->callModifier($this, $name, $parameters);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->value()->getIterator());
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return null;
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps()
    {
        return false;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Illuminate\Database\Eloquent\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw \Illuminate\Database\Eloquent\JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return ($this->getAttribute($key)) ?: $this->value()->{$key};
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->getAttribute($offset);
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
        $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset], $this->relations[$offset]);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    public function __toString()
    {
        return $this->value();
        // return is_array($value) ? null : $value;
    }

    public function __call($method, $arguments)
    {
        return $this->callModifier($method, ...$arguments);
    }

    public function __invoke($parameters = [])
    {
        return $this->value($parameters);
    }

    public function parameters($parameters = [])
    {
        return $this->value($parameters);
    }
}
