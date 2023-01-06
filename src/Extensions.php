<?php

namespace Expressionengine\Coilpack;

use Illuminate\Support\Facades\Event;

class Extensions extends \EE_Extensions
{
    public function __construct($data = [])
    {
        if (! empty($data)) {
            $this->extensions = $data['extensions'];
            $this->version_numbers = $data['version_numbers'];
        } else {
            parent::__construct();
        }
    }

    /**
     * Extension Hook Method
     *
     * Used in ExpressionEngine to call an extension based on whichever
     * hook is being triggered
     *
     * @param	string	Name of the  extension hook
     * @param	mixed
     * @return	mixed
     */
    public function call($which)
    {
        // Fire pre-hook event
        // Events\HookTriggered::dispatch("$which:before", true);
        $value = false;
        $arguments = array_slice(func_get_args(), 1);
        // $arguments = count($arguments) == 1 ? $arguments[0] : $arguments;
        if (Event::hasListeners("ee:$which")) {
            $value = Event::dispatch("ee:$which", $arguments)[0];
        }

        if (parent::active_hook($which)) {
            $value = parent::call(...func_get_args());
        }

        if (Event::hasListeners("ee:$which:final")) {
            // $this->end_script = true;
            $value = Event::dispatch("ee:$which:final", $arguments)[0];
        }

        return $value;

        // echo "<pre> <strong>$which</strong>\n";
        // var_dump($arguments);
        // echo "</pre>";

        // Fire post-hook event
        // Events\HookTriggered::dispatch("$which:after", true);

        // return $arguments;
    }

    /**
     * Active Hook
     *
     * Check If Hook Has Activated Extension
     *
     * @param	string	Name of the  extension hook
     * @return	bool
     */
    public function active_hook($which)
    {
        $hasActiveHooks = parent::active_hook($which);

        /*
        if !hasActiveHooks should we always fire the :before and :after events here?
        */

        // Fire a hook event regardless of whether EE has an active hook
        // $value = Events\HookTriggered::dispatch($which, $hasActiveHooks);
        // if($which == 'typography_parse_type_start') {
        //     dd($hasActiveHooks, $this->hasListeners($which), Event::getListeners('ee:typography_parse_type_start'), Event::getListeners('ee:typography_parse_type_start:final'));
        // }
        // return true;
        return $hasActiveHooks || $this->hasListeners($which);
    }

    public function hasListeners($eventName)
    {
        $events = [
            "ee:$eventName",
            "ee:$eventName:final",
        ];

        $hasListeners = ! empty(array_filter($events, function ($event) {
            // $listeners = array_filter(Event::getListeners($event), function($listener) {
            //     if($listener instanceof \Closure) {
            //         $func = new \ReflectionFunction($listener);
            //         dd($func->getClosureThis());
            //         dd($func->getClosureScopeClass());
            //         // $func->getClosureUsedVariables(),
            //         // print_r($func->getClosureThis());
            //     }
            // });

            // return !empty($listeners);
            return Event::hasListeners($event);
        }));

        return $hasListeners;
    }
}
