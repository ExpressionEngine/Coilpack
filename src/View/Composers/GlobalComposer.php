<?php

namespace Expressionengine\Coilpack\View\Composers;

use Expressionengine\Coilpack\View\GlobalVariables;
use ExpressionEngine\Service\Template\Variables\StandardGlobals;
use Illuminate\View\View;

class GlobalComposer
{
    public static $cache = [];

    // @todo separate global variable collection from view composer
    public function globals()
    {
        if (static::$cache['globals'] ?? false) {
            return static::$cache['globals'];
        }

        ee()->load->library('template', null, 'TMPL');
        ee()->load->library('session');
        $this->loadSiteVariables();
        $globals = new StandardGlobals(ee()->TMPL);

        static::$cache['globals'] = ['global' => new GlobalVariables(array_merge(
            $globals->getTemplateVariables(),
            ee()->config->_global_vars,
            [
                'current_time' => now(),
                'logged_in' => (ee()->session->userdata('member_id') != 0),
                'logged_out' => (ee()->session->userdata('member_id') == 0),
            ]
        ))];

        return static::$cache['globals'];
    }

    public function loadSiteVariables()
    {
        // load site variables into the global_vars array
        foreach ([
            'site_id',
            'site_label',
            'site_short_name',
            'site_name',
            'site_url',
            'site_description',
            'site_index',
            'webmaster_email',
        ] as $site_var) {
            ee()->config->_global_vars[$site_var] = stripslashes(ee()->config->item($site_var));
        }
    }

    public function urlSegments()
    {
        $segments = ee()->uri->segment_array();
        $defaults = array_fill(1, 9, null);

        $segmentVariables = [];
        foreach ($defaults as $key => $value) {
            $segmentVariables["segment_$key"] = $segments[$key] ?? $value;
        }

        // Define some path and template related global variables
        return array_merge($segmentVariables, [
            'last_segment' => end($segments),
            'current_url' => ee()->functions->fetch_current_uri(),
            'current_path' => (ee()->uri->uri_string) ? str_replace(['"', "'"], ['%22', '%27'], ee()->uri->uri_string) : '/',
            'current_query_string' => http_build_query($_GET), // GET has been sanitized!
            // 'template_name' => $this->template_name,
            // 'template_group' => $this->group_name,
            // 'template_group_id' => $this->template_group_id,
            // 'template_id' => $this->template_id,
            // 'template_type' => $this->embed_type ?: $this->template_type,
            // 'is_ajax_request' => AJAX_REQUEST,
            // 'is_live_preview_request' => ee('LivePreview')->hasEntryData(),
        ]);
    }

    public function all()
    {
        return array_merge($this->globals(), $this->urlSegments());
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        foreach ($this->all() as $name => $value) {
            $view->with($name, $value);
        }
    }
}
