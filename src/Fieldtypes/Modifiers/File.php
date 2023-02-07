<?php

namespace Expressionengine\Coilpack\Fieldtypes\Modifiers;

use Expressionengine\Coilpack\Facades\Coilpack;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Modifier;

// use Expressionengine\Coilpack\Models\FieldContent;

class File extends Modifier
{
    public function handle(FieldtypeOutput $content, $parameters = [])
    {
        $handler = $this->fieldtype->getHandler();
        $data = $handler->pre_process($content->raw_content);

        $modified = Coilpack::isolateTemplateLibrary(function ($template) use ($data, $parameters) {
            $output = $this->callHandler($data, $parameters);

            return $template->get_data() ?: $output;
        });

        // Unwrap the output if we have a nested array
        $modified = (is_array($modified) && count($modified) === 1 && is_array(current($modified))) ? $modified[0] : $modified;

        return FieldtypeOutput::for($this->fieldtype)->value($modified)->string($modified['url']);
    }

    protected function callHandler($data, $parameters)
    {
        $method = 'replace_'.$this->attributes['name'];
        $handler = $this->fieldtype->getHandler();

        if ($this->attributes['name'] === 'manipulation') {
            $data['url'] = $handler->replace_tag_catchall($data, [], false, current($parameters));

            return $data;
        }

        // Sending fake tagdata to force a call to template parser so we can get more data back
        return $handler->{$method}($data, $parameters, '{!-- coilpack:fake --}');
    }
}
