<?php

namespace Expressionengine\Coilpack\View;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Tag
{
    /**
     * A list of arguments passed to the tag
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * A collection of parameters available on the tag
     *
     * @var Collection|null
     */
    protected $parameters;

    /**
     * Run the tag logic to produce the output
     *
     * @return mixed
     */
    abstract public function run();

    /**
     * Get a collection of defined Parameters
     *
     * @return Collection
     */
    public function parameters(): Collection
    {
        if (! $this->parameters) {
            $this->parameters = collect($this->defineParameters())->keyBy('name');
        }

        return $this->parameters;
    }

    /**
     * Define the parameters available on this Tag
     *
     * @return array
     */
    public function defineParameters(): array
    {
        return [];
    }

    /**
     * Set the arguments to be used by the tag
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
     * @param  string  $key
     * @return bool
     */
    public function hasArgument(string $key)
    {
        return isset($this->arguments[$key]);
    }

    /**
     * Retrieve an argument value
     * If a value is not set the parameter's default value will be returned
     *
     * @param  string  $key
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

        return $value;
    }

    /**
     * Get a list of all mutated arguments
     *
     * @return array
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

    /**
     * Process this tag with the provided arguments
     *
     * @param  array  $arguments
     * @return mixed
     */
    public function __invoke($arguments = [])
    {
        return $this->arguments($arguments)->run();
    }

    /**
     * Cast the tag to a string by invoking the process method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->run();
    }
}
