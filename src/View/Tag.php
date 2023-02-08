<?php

namespace Expressionengine\Coilpack\View;

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
     * Run the tag logic to produce the output
     *
     * @return mixed
     */
    abstract public function run();

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

    public function hasArgument($key)
    {
        return isset($this->arguments[$key]);
    }

    public function getArgument($key)
    {
        return $this->arguments[$key];
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
