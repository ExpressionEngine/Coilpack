<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Api\Graph\Support\TagQuery;
use Expressionengine\Coilpack\Contracts\ConvertsToGraphQL;
use Expressionengine\Coilpack\Facades\GraphQL;
use Expressionengine\Coilpack\Models\Addon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Exp
{
    protected static $booted = false;

    protected static $tags = [];

    protected static $addons;

    public static function boot()
    {
        if (static::$booted) {
            return;
        }

        $modules = Addon\Module::get()->keyBy(function ($module) {
            return strtolower($module->module_name);
        })->all();

        $plugins = Addon\Plugin::get()->keyBy(function ($plugin) {
            return strtolower($plugin->plugin_name);
        })->all();

        static::$addons = array_merge($plugins, $modules);
        static::$booted = true;
    }

    public function encode()
    {
        // Email encode: {encode="you@yoursite.com" title="click Me"}
        // if (strpos($str, LD . 'encode=') !== false) {
        //     if ($this->encode_email == true) {
        //         $str = $this->parse_encode_email($str);
        //     } else {
        //         /* -------------------------------------------
        //         /*  Hidden Configuration Variable
        //         /*  - encode_removed_text => Text to display if there is an {encode=""}
        //             tag but emails are not to be encoded
        //         /* -------------------------------------------*/

        //         $str = preg_replace(
        //             "/" . LD . "\s*encode=(.+?)" . RD . "/",
        //             (ee()->config->item('encode_removed_text') !== false) ? ee()->config->item('encode_removed_text') : '',
        //             $str
        //         );
        //     }
        // }
    }

    public function registerTag($name, $class)
    {
        if (is_string($class)) {
            $class = new $class;
        }

        Arr::set(static::$tags, $name, $class);

        if ($class instanceof Tag && $class instanceof ConvertsToGraphQL) {
            $name = str_replace('.', '_', Str::snake("exp_$name"));
            $query = new TagQuery($class, $name);
            app()->bind("graphql.query.$name", function ($app) use ($query) {
                return $query;
            });

            GraphQL::addQuery("graphql.query.$name", $name);
        }
    }

    public function path(...$arguments)
    {
        // Path variable: {path=group/template}
        $arguments = (empty($arguments)) ? [''] : $arguments;
        $arguments[0] = ee()->functions->create_url($arguments[0]);

        return implode('/', $arguments);
    }

    public function redirect($str)
    {
        return redirect($str);
    }

    public function route($str)
    {
        // Route variable: {route=group/template foo='bar'}
        return ee()->functions->create_route($str);
    }

    public function embed($view, $vars = [])
    {
        $pieces = explode('/', $view);
        $site_id = ee()->config->item('site_id');

        if (count($pieces) !== 2) {
            throw new \Exception('Embedded view name must be of the format `template_group/template`');
        }

        return tap(ee()->TMPL, function ($tmpl) use ($pieces, $site_id, $vars) {
            $tmpl->embed_vars = $vars;
            $template = $tmpl->fetch_template($pieces[0], $pieces[1], false, $site_id);
            $tmpl->parse($template, true, $site_id, false);
        })->template;
    }

    public function __get($key)
    {
        static::boot();
        $key = strtolower($key);
        $fallback = null;

        if (array_key_exists($key, static::$addons)) {
            $addon = ee('Addon')->get($key);
            $fallback = new TagBuilder($key, $addon); // static::$addons[$key]
        }

        // give precedence to directly registered tags
        if (array_key_exists($key, static::$tags)) {
            if (is_array(static::$tags[$key])) {
                return new TagProxy(static::$tags[$key], $fallback);
            } else {
                return static::$tags[$key];
            }
        }

        return $fallback;
    }

    public function __isset($key)
    {
        static::boot();

        return array_key_exists(strtolower($key), static::$tags) || (array_key_exists(strtolower($key), static::$addons));
    }
}
