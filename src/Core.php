<?php

namespace Expressionengine\Coilpack;

class Core
{
    public function __construct(\ExpressionEngine\Core\Core $core)
    {
        $this->core = $core;
    }

    public function bootstrap()
    {
        $app = $this->core->loadApplicationCore();

        // $GLOBALS['RTR']->_set_routing();

        ee()->load->library('core');
        ee()->core->bootstrap();

        ee()->remove('extensions');
        ee()->set('extensions', new \Expressionengine\Coilpack\Extensions);

        $this->core->bootstrap();
        // $this->core->loadSnippets();

        // ee()->remove('TMPL');
        // ee()->set('TMPL', new \Expressionengine\Coilpack\View\TemplateStub);
    }

    public function loadSnippets()
    {
        ee()->load->library('session');
        $fresh = ee('Model')->make('Snippet')->loadAll();

        if ($fresh->count() > 0) {
            $snippets = $fresh->getDictionary('snippet_name', 'snippet_contents');

            // Thanks to @litzinger for the code suggestion to parse
            // global vars in snippets...here we go.

            $var_keys = [];

            foreach (ee()->config->_global_vars as $k => $v) {
                $var_keys[] = LD.$k.RD;
            }

            $snippets = str_replace($var_keys, ee()->config->_global_vars, $snippets);

            ee()->config->_global_vars = ee()->config->_global_vars + $snippets;

            unset($snippets);
            unset($fresh);
            unset($var_keys);
        }
    }

    public function __call($method, $arguments)
    {
        return $this->core->{$method}(...$arguments);
    }

    public function runGlobal()
    {
        $request = \ExpressionEngine\Core\Request::fromGlobals();
        $response = $this->core->run($request);

        $body = $this->accessRestrictedProperty($response, 'body');
        $status = $this->accessRestrictedProperty($response, 'status');
        $headers = $this->accessRestrictedProperty($response, 'headers');

        if ($body == '') {
            return Response::fromOutput($status);
        }

        return new \Illuminate\Http\Response($body, $status, $headers);
    }

    protected function accessRestrictedProperty($object, $property)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue($object);
    }
}
