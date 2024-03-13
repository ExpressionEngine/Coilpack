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
        return Coilpack::isolateTemplateLibrary(function ($template) {
            $output = $this->getInstanceClass()->{$this->method}();
            $templateData = $template->get_data();
            $templateOutput = \Expressionengine\Coilpack\TemplateOutput::make();

            // If the tag generated non-empty string output we should pass that along to the TemplateOutput class
            // this could be a single tag that is passing along its final value while also parsing/setting data
            // that will be available through $template->get_data()
            if (! empty($output) && is_string($output)) {
                $templateOutput->string($output);
            }

            // If the Tag stored data for us in the template library that is preferable to the generated output
            $templateData = $templateData ?: $output;

            // If our template data is an array of arrays we will transform it into a collection of TemplateOutputs
            if (is_array($templateData) && is_array(current($templateData))) {
                $templateData = collect($templateData)->map(function ($row) {
                    return \Expressionengine\Coilpack\TemplateOutput::make()->value($row);
                });
            }

            if (! empty($templateData)) {
                $templateOutput->value($templateData);
            }

            return $templateOutput;
        }, $this->getArguments());
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
