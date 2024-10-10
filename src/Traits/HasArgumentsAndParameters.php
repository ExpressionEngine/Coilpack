<?php

namespace Expressionengine\Coilpack\Traits;

use Expressionengine\Coilpack\Support\Arguments\Argument;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasArgumentsAndParameters
{
    /**
     * A list of arguments passed
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * A collection of parameters available
     *
     * @var Collection|null
     */
    protected $parameters;

    /**
     * Get a collection of defined Parameters
     */
    public function parameters(): Collection
    {
        if (! $this->parameters) {
            $this->parameters = collect($this->defineParameters())->keyBy('name');
        }

        return $this->parameters;
    }

    /**
     * Define the parameters available
     */
    public function defineParameters(): array
    {
        return [];
    }

    /**
     * Set the arguments to be used
     *
     * @param  array  $arguments
     * @return static
     */
    public function arguments($arguments = [])
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Set the value for an argument
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return static
     */
    public function setArgument($key, $value)
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    public function getArgumentFallback($key, $value)
    {
        return $value;
    }

    /**
     * Determine if a get mutator exists for a argument.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasArgumentMutator($key)
    {
        return method_exists($this, 'get'.Str::studly($key).'Argument');
    }

    /**
     * Get the value of a argument using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function getMutatedArgumentValue($key, $value)
    {
        return $this->{'get'.Str::studly($key).'Argument'}($value);
    }

    /**
     * Determine whether or not an argument was set
     *
     * @return bool
     */
    public function hasArgument(string $key)
    {
        return isset($this->arguments[$key]);
    }

    /**
     * Determine whether or not any of the argument names are set
     *
     * @return bool
     */
    public function hasAnyArgument(...$keys)
    {
        foreach($keys as $key) {
            if($this->hasArgument($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve an argument value
     * If a value is not set the parameter's default value will be returned
     *
     * @return mixed
     */
    public function getArgument(string $key)
    {
        $value = null;

        if ($this->hasArgument($key)) {
            $value = $this->arguments[$key];
        }
        // If a default value was defined on the parameter use it
        elseif ($this->parameters()->has($key)) {
            $value = $this->parameters()->get($key)->defaultValue ?? null;
        }

        if ($this->hasArgumentMutator($key)) {
            $value = $this->getMutatedArgumentValue($key, $value);
        } else {
            $value = $this->getArgumentFallback($key, $value);
        }

        return $value instanceof Argument || is_array($value) ? $value : new Argument($value);
    }

    /**
     * Get a list of all mutated arguments
     */
    public function getArguments(): array
    {
        $defaults = $this->parameters()->filter(function ($parameter) {
            return ! is_null($parameter->defaultValue);
        })->transform(function ($parameter) {
            return $parameter->defaultValue;
        });

        $arguments = $defaults->merge($this->arguments);

        return $arguments->transform(function ($value, $key) {
            if ($this->hasArgumentMutator($key)) {
                return $this->getMutatedArgumentValue($key, $value);
            } else {
                return $this->getArgumentFallback($key, $value);
            }
        })->toArray();
    }
}
