<?php

namespace Expressionengine\Coilpack\View;

use Illuminate\Support\Facades\View;

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
        if (in_array($this->template_engine, ['twig', 'blade'])) {
            $templateName = 'ee::'.$this->group_name.'.'.$this->template_name;
            $this->log_item(vsprintf('Coilpack parsing template %s with %s', [
                $this->group_name.'/'.$this->template_name,
                $this->template_engine,
            ]));

            $rendered = View::make($templateName, $this->getData($is_embed))->render();

            if ($is_embed) {
                $this->template = $rendered;
            } else {
                $this->final_template = $rendered;
            }

            return;
        }

        return parent::parse($str, $is_embed, $site_id, $is_layout);
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
}
