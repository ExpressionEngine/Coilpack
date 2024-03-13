<?php

namespace Expressionengine\Coilpack;

class Coilpack
{
    /**
     * Execute a closure while stubbing the current ee()->TMPL library
     * The stubbed library is passed to the closure as $template
     *
     * @param  mixed  $parameters
     * @return mixed
     */
    public function isolateTemplateLibrary(callable $callable, $parameters = null)
    {
        $tmpl = ee()->TMPL;
        ee()->remove('TMPL');
        $template = new View\TemplateStub;
        ee()->set('TMPL', $template);

        // Allow setting the EE Template Library's tagdata with a parameter
        if ($parameters['tagdata'] ?? false) {
            ee()->TMPL->tagdata = $parameters['tagdata'];
            unset($parameters['tagdata']);
        }

        // Assign parameters to the template library
        if ($parameters) {
            $template->tagparams = $parameters;
        }

        // This sets the proper site_ids for the template library based on parameters set
        $template->_fetch_site_ids();

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

    /**
     * Register an extension for the Twig template engine
     *
     * @param  \Twig\Extension\ExtensionInterface  $extensionClass
     * @return void
     */
    public function addTwigExtension($extensionClass)
    {
        $extensionClass = (is_string($extensionClass)) ? new $extensionClass : $extensionClass;

        return \TwigBridge\Facade\Twig::addExtension($extensionClass);
    }
}
