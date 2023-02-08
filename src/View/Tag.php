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
        foreach ($arguments as $key => $value) {
            if ($this->hasArgumentMutator($key)) {
                $value = $this->setMutatedArgumentValue($key, $value);
            }

            $this->arguments[$key] = $value;
        }

        return $this;
    }

    /**
     * Determine if a set mutator exists for a argument.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasArgumentMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Argument');
    }

    /**
     * Set the value of a argument using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function setMutatedArgumentValue($key, $value)
    {
        return $this->{'set'.Str::studly($key).'Argument'}($value);
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
    public function getArgument(string $key): mixed
    {
        if ($this->hasArgument($key)) {
            return $this->arguments[$key];
        }

        // If a default value was defined on the parameter use it
        if ($this->parameters()->has($key)) {
            return $this->parameters()->get($key)->defaultValue ?? null;
        }
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
