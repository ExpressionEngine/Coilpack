<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Facades\Coilpack;
use Traversable;

class TagBuilder extends Tag implements \IteratorAggregate
{
    /**
     * The name of the module
     *
     * @var string
     */
    protected $name;

    /**
     * The method being called on the module
     *
     * @var string
     */
    protected $method;

    public function __construct($name, $instance)
    {
        $this->name = $name;
        $this->instance = $instance;
    }

    public function __call($method, $args)
    {
        // If we already have a method set then we can assume this __call request
        // is intended for fluently building the tag
        // i.e. $exp->module->tag->method($args)
        // if(!is_null($this->method)) {
        //     $this->arguments[$method] = $this->processArguments($args);

        //     return $this;
        // }

        // If $this->method is null though we will assume this request is meant
        // to execute the tag with the provided arguments
        // i.e. $exp->module->method($args)
        $this->method = $method;
        $this->arguments = (is_array($args)) ? current($args) : $args;
        // $this->arguments = $this->processArguments($args);

        return $this->run();
    }

    /**
     * Use the __get magic method to set the method name for this tag
     * i.e. `exp->tag->method
     *
     * @param [type] $key
     * @return void
     */
    public function __get($key)
    {
        $this->method = $key;

        return $this;
    }

    /**
     * This is needed to satisfy Twig.  Since we don't know all of the available
     * arguments or possible method names we will just always return true
     *
     * @param [type] $key
     * @return bool
     */
    public function __isset($key)
    {
        return true;
    }

    // Too much magic, unnecessary
    // public function __invoke($arguments = null)
    // {
    //     if(is_null($this->method)) {
    //         throw new \Exception("Please specify a method on the '$name' tag");
    //     }

    //     if(!is_null($arguments)) {
    //         $this->arguments = $arguments;
    //     }

    //     return $this->process();
    // }

    public function __toString()
    {
        $output = $this->run();

        // Automatically unwrap an array with single item when converting to string
        if ($output instanceof \Countable && count($output) === 1) {
            return (string) $output[0];
        }

        return $output;
    }

    public function run()
    {
        $output = Coilpack::isolateTemplateLibrary(function ($template) {
            $output = $this->getInstanceClass()->{$this->method}();
            // If the Tag stored data for us in the template library that is preferable to the generated output
            return $template->get_data() ?: $output;
        }, $this->arguments);

        return is_array($output) && is_array(current($output)) ? collect($output)->map(function ($row) {
            return \Expressionengine\Coilpack\TemplateOutput::make()->value($row);
        }) : \Expressionengine\Coilpack\TemplateOutput::make()->value($output);
    }

    private function getInstanceClass()
    {
        $class = '\\'.ltrim($this->instance->getFrontendClass(), '\\');

        return new $class;
    }

    private function processArguments($value)
    {
        if (is_array($value)) {
            if (count($value) > 1) {
                return $value;
            } else {
                $value = current($value);
            }
        }

        return (is_string($value) && strpos($value, ',')) ? explode(',', $value) : $value;
    }

    public function getIterator(): Traversable
    {
        $output = $this->run();

        if ($output instanceof \IteratorAggregate) {
            return $output->getIterator();
        }

        return new \ArrayIterator(is_array($output) ? $output : []);
    }
}
