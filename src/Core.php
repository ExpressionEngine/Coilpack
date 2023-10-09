<?php

namespace Expressionengine\Coilpack;

class Core
{

    use Traits\CanAccessRestrictedClass;

    protected $core;

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

        if (defined('REQ') && REQ == 'CLI') {
            return $this->runCli($request);
        }

        $response = $this->core->run($request);

        $body = $this->getRestrictedProperty($response, 'body');
        $status = $this->getRestrictedProperty($response, 'status');
        $headers = $this->getRestrictedProperty($response, 'headers');

        if ($body == '') {
            return Response::fromOutput($status);
        }

        return new \Illuminate\Http\Response($body, $status, $headers);
    }

    protected function runCli($request)
    {
        $application = $this->core->loadApplicationCore();
        $application->setRequest($request);

        if (defined('BOOT_ONLY')) {
            return $this->core->bootOnly($request);
        }

        $this->core->getLegacyApp()->includeBaseController();

        // We need to load the core bootstrap globals here
        ee()->load->library('core');
        ee()->core->bootstrap();

        $cli = new \ExpressionEngine\Cli\Cli();

        return $cli;
    }
}
