<?php

namespace Expressionengine\Coilpack\View;

// use ExpressionEngine\Service\Template\EE_Template;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use TwigBridge\Facade\Twig;

class TemplateStub extends \EE_Template
{
    protected $data_capture = [];

    public function __construct()
    {
        parent::__construct();

        $this->tagparams = [
            'dynamic' => 'no',
        ];
        $this->site_ids = [ee()->config->item('site_id') ?: 1];

        $this->data_capture = [
            'parse_variables' => null,
            'parse_variables_row' => [],
        ];

        $this->process_data = false;

        if (! isset($this->template_engine)) {
            $this->template_engine = '';
        }
    }

    public function parse_variables($tagdata, $variables, $enable_backspace = true)
    {
        $this->data_capture['parse_variables'] = $variables;

        return parent::parse_variables($tagdata, $variables, $enable_backspace);
    }

    public function parse_variables_row($tagdata, $variables, $solo = true)
    {
        $this->data_capture['parse_variables_row'][] = $variables;

        return parent::parse_variables_row($tagdata, $variables, $solo);
    }

    /**
     * Remove all EE Code Comment Strings
     *
     * EE Templates have a special EE Code Comments for site designer notes and are removed prior
     * to Template processing.
     *
     * @param   string
     * @return  string
     */
    public function remove_ee_comments($str)
    {
        $str = str_replace('{!-- template:twig --}', '{# template:twig #}', $str);
        $str = str_replace('{!-- template:blade --}', '{{-- template:blade --}}', $str);

        return parent::remove_ee_comments($str);
    }

    /**
     * Get any template variable data we are able to capture.
     *
     * @return mixed
     */
    public function get_data()
    {
        $data = (method_exists(get_parent_class($this), 'get_data')) ? parent::get_data() : null;

        // Prefer any data that was set explicitly with set_data()
        if (! is_null($data)) {
            return $data;
        }

        // Use data captured from a call to parse_variables()
        if (! empty($this->data_capture['parse_variables'])) {
            return $this->data_capture['parse_variables'];
        }

        // Use data captured from a call to parse_variables_row()
        if (! empty($this->data_capture['parse_variables_row'])) {
            return count($this->data_capture['parse_variables_row']) > 1
                ? $this->data_capture['parse_variables_row']
                : $this->data_capture['parse_variables_row'][0];
        }

        return null;
    }

    /**
     * Parse a string as a template
     *
     * @param   string
     * @param   string
     * @return  void
     */
    public function parse(&$str, $is_embed = false, $site_id = '', $is_layout = false)
    {
        $templateName = 'ee::'.$this->group_name.'.'.$this->template_name;
        if ($this->template_engine === 'twig' || Str::startsWith($this->template, '{# template:twig #}')) {
            // $engine = app('view')->getEngineResolver()->resolve('twig');
            // Tell Laravel's View Factory to render html files with Twig
            // this is necessary for any includes or layouts referenced in this template
            app('view')->addExtension('html', 'twig');
            $template = Twig::createTemplate(str_replace('{# template:twig #}', '', $str), $templateName);
            $rendered = $template->render($this->getData($is_embed));
            if ($is_embed) {
                $this->template = $rendered;
            } else {
                $this->final_template = $rendered;
            }

            return;
        }

        if ($this->template_engine === 'blade' || Str::startsWith($this->template, '{{-- template:blade --}}')) {
            // See if we can tap into this for versions 7.x - 9.x (https://laravel.com/docs/9.x/blade#rendering-inline-blade-templates)
            // $engine = app('view')->getEngineResolver()->resolve('blade');

            // Tell Laravel's View Factory to render html files with Blade
            // this is necessary for any includes or layouts referenced in this template
            app('view')->addExtension('html', 'blade');
            $template = Blade::compileString(str_replace('{{-- template:blade --}}', '', $str));

            $data = $this->createView($templateName, 'blade', $this->getData($is_embed));

            $rendered = $this->render($template, $data);
            if ($is_embed) {
                $this->template = $rendered;
            } else {
                $this->final_template = $rendered;
            }

            return;
        }

        return parent::parse($str, $is_embed, $site_id, $is_layout);
    }

    protected function createView($name, $language, $context)
    {
        $env = resolve('view');
        $viewName = \Illuminate\View\ViewName::normalize($name ?: $this->template_name);

        $view = new \Illuminate\View\View(
            $env,
            $env->getEngineResolver()->resolve($language),
            $viewName,
            null,
            $context
        );
        $env->callCreator($view);
        $env->callComposer($view);

        return $view->getData();
    }

    protected function getData($is_embed = false)
    {
        $shared = View::getShared();
        $globals = (new Composers\GlobalComposer)->globals();

        return array_merge(
            $shared,
            $globals,
            ($is_embed) ? ['embed' => $this->embed_vars] : []
        );
    }

    protected function render($__php, $__data)
    {
        if (! array_key_exists('__env', $__data)) {
            $__data['__env'] = app(\Illuminate\View\Factory::class);
        }
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?'.'>'.$__php);
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            throw new \Error($e);
        }

        return ob_get_clean();
    }
}
