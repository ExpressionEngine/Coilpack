<?php

namespace Expressionengine\Coilpack\View;

use Illuminate\Support\Str;

abstract class Tag
{
    /**
     * A list of parameters passed to the tag
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Run the tag logic to produce the output
     *
     * @return mixed
     */
    abstract public function run();

    /**
     * Set the parameters to be used by the tag
     *
     * @param  array  $parameters
     * @return static
     */
    public function parameters($parameters = [])
    {
        foreach ($parameters as $key => $value) {
            if ($this->hasParameterMutator($key)) {
                $value = $this->setMutatedParameterValue($key, $value);
            }

            $this->parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * Determine if a set mutator exists for a parameter.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasParameterMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Parameter');
    }

    /**
     * Set the value of a parameter using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function setMutatedParameterValue($key, $value)
    {
        return $this->{'set'.Str::studly($key).'Parameter'}($value);
    }

    public function hasParameter($key)
    {
        return isset($this->parameters[$key]);
    }

    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * Process this tag with the provided parameters
     *
     * @param  array  $parameters
     * @return mixed
     */
    public function __invoke($parameters = [])
    {
        return $this->parameters($parameters)->run();
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
