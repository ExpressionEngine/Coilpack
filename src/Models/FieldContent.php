<?php

namespace Expressionengine\Coilpack\Models;

use Illuminate\Contracts\Support\Jsonable;

class FieldContent implements Jsonable, \IteratorAggregate, \ArrayAccess
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new model instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getFieldtype()
    {
        if (isset($this->attributes['fieldtype'])) {
            return $this->fieldtype;
        }

        $this->attributes['fieldtype'] = $this->field->getFieldtype();

        return $this->fieldtype;
    }

    /**
     * Get the value of this Field Content by applying the fieldtype
     *
     * @return \Expressionengine\Coilpack\FieldtypeOutput
     */
    public function value(array $parameters = [])
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

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->value()->getIterator());
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
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

        // if (JSON_ERROR_NONE !== json_last_error()) {
        //     throw \Illuminate\Database\Eloquent\JsonEncodingException::forModel($this, json_last_error_msg());
        // }

        return $json;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }

        if ($this->hasAttribute($key)) {
            return $this->attributes[$key];
        }
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
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
        // return ($this->getAttribute($key)) ?: $this->value()->{$key};
        if ($this->getAttribute($key)) {
            return $this->getAttribute($key);
        }

        $value = $this->value();
        if (isset($value->$key)) {
            return $value->$key;
        }

        if ($value->hasModifier($key)) {
            return $value->callModifier($key);
        }

        return null;
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
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        if ($this->offsetExists($key)) {
            return true;
        }

        $value = $this->value();

        return isset($value->$key) || $value->hasModifier($key);
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
        return (string) $this->value();
    }

    public function __call($method, $arguments)
    {
        return $this->value()->$method(...$arguments);
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
