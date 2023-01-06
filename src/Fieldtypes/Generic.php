<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\FieldContent;
use Illuminate\Support\Str;

class Generic extends Fieldtype
{
    private $handler = null;

    public function __construct(string $name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getHandler()
    {
        if ($this->handler) {
            return $this->handler;
        }

        ee()->load->library('api');
        ee()->legacy_api->instantiate('channel_fields');
        ee()->api_channel_fields->include_handler($this->name);
        if (empty(ee()->api_channel_fields->custom_fields)) {
            ee()->api_channel_fields->fetch_custom_channel_fields();
        }

        $this->handler = ee()->api_channel_fields->setup_handler($this->id ?: $this->name, true);

        return $this->handler;
    }

    public function apply(FieldContent $content, array $parameters = [])
    {
        $handler = $this->getHandler();

        $data = $content->getAttribute('data');

        $output = \Expressionengine\Coilpack\Facades\Coilpack::isolateTemplateLibrary(function ($template) use ($handler, $data, $parameters) {
            $output = $handler->replace_tag($data, $parameters);
            // If the Fieldtype stored data for us in the template library that is preferable to the generated output
            return $template->get_data() ?: $output;
        });

        return FieldtypeOutput::make($output);
    }

    public function modifiers()
    {
        // @todo Cache this statically
        return collect(get_class_methods($this->getHandler()))->flatMap(function ($method) {
            if (Str::startsWith($method, 'replace_') && $method !== 'replace_tag') {
                return [
                    substr($method, 8) => new Modifiers\Generic($this, [
                        'name' => substr($method, 8),
                    ]),
                ];
            }

            return [];
        })->filter()->toArray();
    }
}
