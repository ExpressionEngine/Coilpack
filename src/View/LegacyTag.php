<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Facades\Coilpack;
use Traversable;

class LegacyTag extends Tag implements \IteratorAggregate
{
    protected $method;

    protected $instance;

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
        }, $this->getArguments());

        return is_array($output) && is_array(current($output)) ? collect($output)->map(function ($row) {
            return \Expressionengine\Coilpack\TemplateOutput::make()->value($row);
        }) : \Expressionengine\Coilpack\TemplateOutput::make()->value($output);
    }

    private function getInstanceClass()
    {
        $class = '\\'.ltrim($this->instance->getFrontendClass(), '\\');

        return new $class;
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
