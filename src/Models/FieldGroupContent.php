<?php

namespace Expressionengine\Coilpack\Models;

use Expressionengine\Coilpack\Models\Channel\ChannelFieldGroup;
use Illuminate\Contracts\Support\Jsonable;

class FieldGroupContent implements \ArrayAccess, \Countable, \IteratorAggregate, Jsonable
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Group model
     *
     * @var ChannelFieldGroup
     */
    protected $group;

    /**
     * Field Contents for the Group
     *
     * @var Illuminate\Support\Collection
     */
    protected $fields;

    /**
     * Create a new model instance.
     *
     * @return void
     */
    public function __construct(ChannelFieldGroup $group)
    {
        $this->group = $group;
        $this->attributes = array_merge($group->attributesToArray(), [
            '_field_name' => $group->short_name,
            '_field_type' => 'field_group',
        ]);
        $this->fields = collect();
    }

    /**
     * Get the Group model
     *
     * @return ChannelFieldGroup
     */
    public function group()
    {
        return $this->group;
    }

    /**
     * Get the collection of fields
     *
     * @return Illuminate\Support\Collection
     */
    public function fields()
    {
        return $this->fields;
    }

    public function getIterator(): \Traversable
    {
        return $this->fields->getIterator();
    }

    public function count(): int
    {
        return $this->fields->count();
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
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

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

        if (in_array($key, ['group', 'fields'])) {
            return $this->$key;
        }

        if ($this->hasAttribute($key)) {
            return $this->attributes[$key];
        }
    }

    /**
     * Check to see if an attribute exists
     *
     * @param  string  $key
     * @return bool
     */
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
        if ($this->getAttribute($key)) {
            return $this->getAttribute($key);
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
    public function offsetGet(mixed $offset): mixed
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
        if ($this->offsetExists($key) || in_array($key, ['group', 'fields'])) {
            return true;
        }
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
}
