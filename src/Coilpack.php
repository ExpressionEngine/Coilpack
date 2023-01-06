<?php

namespace Expressionengine\Coilpack;

class Coilpack
{
    /**
     * Execute a closure while stubbing the current ee()->TMPL library
     * The stubbed library is passed to the closure as $template
     *
     * @param  callable  $callable
     * @param  mixed  $parameters
     * @return mixed
     */
    public function isolateTemplateLibrary(callable $callable, $parameters = null)
    {
        $tmpl = ee()->TMPL;
        ee()->remove('TMPL');
        $template = new View\TemplateStub;
        ee()->set('TMPL', $template);

        if ($parameters) {
            $template->tagparams = $parameters;
        }

        $output = $callable($template);

        ee()->remove('TMPL');
        ee()->set('TMPL', $tmpl);

        return $output;
    }

    /**
     * Register a tag
     *
     * @param  string  $name
     * @param  string  $class
     * @return void
     */
    public function registerTag($name, $class)
    {
        return app(View\Exp::class)->registerTag($name, $class);
    }

    /**
     * Register a fieldtype
     *
     * @param  string  $name
     * @param  string  $class
     * @return void
     */
    public function registerFieldtype($name, $class)
    {
        return app(FieldtypeManager::class)->register($name, $class);
    }
}
