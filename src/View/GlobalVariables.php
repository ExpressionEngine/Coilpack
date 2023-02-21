<?php

namespace Expressionengine\Coilpack\View;

use ArrayAccess;
use Illuminate\Support\Str;
use IteratorAggregate;
use Traversable;

class GlobalVariables implements ArrayAccess, IteratorAggregate
{
    protected $variables = [];

    protected $reservedCharacters = [':', '->', '.', '-'];

    protected $separator = ':';

    public function __construct($variables = [])
    {
        $this->setItems($this->groupVariables($variables));
    }

    /**
     * Find a variable for the given key
     *
     * @param  string  $key
     * @return mixed
     */
    public function find($key)
    {
        $key = $this->normalizeSeparators($key);
        $segments = array_reverse(explode($this->separator, $key));
        $variables = $this->variables;

        while (! empty($segments)) {
            $segment = array_pop($segments);

            if (! isset($variables[$segment])) {
                throw new \Exception("Global variable '$key' not defined.");
            }

            if (! is_array($variables[$segment])) {
                return $variables[$segment];
            }

            if (isset($variables[$segment]['_value']) && empty($segments)) {
                return $variables[$segment]['_value'];
            }

            $variables = $variables[$segment];
        }

        throw new \Exception("Global variable '$key' not defined.");
    }

    /**
     * Set the ite
     *
     * @param [type] $variables
     * @return void
     */
    public function setItems($variables)
    {
        $this->variables = $variables;

        return $this;
    }

    public function groupVariables($variables)
    {
        return array_reduce(array_keys($variables), function ($carry, $variable) use ($variables) {
            $value = $variables[$variable];

            if (Str::contains($variable, $this->reservedCharacters)) {
                // normalize separators
                $variable = $this->normalizeSeparators($variable);
                $pieces = array_reverse(explode($this->separator, $variable));
                $array = &$carry;

                while (! empty($pieces)) {
                    $key = array_pop($pieces);

                    if (empty($key)) {
                        continue;
                    }

                    if (! isset($array[$key])) {
                        $array[$key] = [];
                    } elseif (! is_array($array[$key])) {
                        $array[$key] = [
                            '_value' => $array[$key],
                        ];
                    }

                    if (! empty($pieces)) {
                        $array = &$array[$key];
                    }
                }

                $array[$key] = $value;
            } else {
                $carry[$variable] = $value;
            }

            return $carry;
        }, []);
    }

    /**
     * Normalize any reserved characters into a single separator
     *
     * @param  string  $variable
     * @return string
     */
    protected function normalizeSeparators($variable)
    {
        return str_replace($this->reservedCharacters, $this->separator, $variable);
    }

    /**
     * Determine if an item exists at an offset.
     */
    public function offsetExists($key): bool
    {
        return isset($this->variables[$key]);
    }

    /**
     * Get an item at a given offset.
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        if (! is_array($this->variables[$key])) {
            return $this->variables[$key];
        } elseif (isset($this->variables[$key]['_value']) && count($this->variables[$key]) == 1) {
            return $this->variables[$key]['_value'];
        } elseif (is_array($this->variables[$key])) {
            return (new static)->setItems($this->variables[$key]);
        }

        return $this->variables[$key];
    }

    /**
     * Set the item at a given offset.
     */
    public function offsetSet($key, $value): void
    {
        if (is_null($key)) {
            $this->variables[] = $value;
        } else {
            $this->variables[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     */
    public function offsetUnset($key): void
    {
        unset($this->variables[$key]);
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->variables);
    }

    /**
     * Dynamically retrieve a value.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Dynamically retrieve a value.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $variable = implode($this->separator, array_merge([$method], $parameters));

        return $this->find($variable);
    }

    /**
     * Dynamically retrieve a value.
     *
     * @param  string  $variable
     * @return mixed
     */
    public function __invoke($variable)
    {
        return $this->find($variable);
    }
}
