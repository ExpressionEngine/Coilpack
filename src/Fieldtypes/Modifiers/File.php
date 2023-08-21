<?php

namespace Expressionengine\Coilpack\Fieldtypes\Modifiers;

use Expressionengine\Coilpack\Facades\Coilpack;
use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Modifier;

class File extends Modifier
{
    public function handle(FieldtypeOutput $content, $parameters = [])
    {
        $data = $content->toArray();

        $modified = Coilpack::isolateTemplateLibrary(function ($template) use ($data, $parameters) {
            $output = $this->callHandler($data, $parameters);

            return $template->get_data() ?: $output;
        });

        // Unwrap the output if we have a nested array
        $modified = (is_array($modified) && count($modified) === 1 && is_array(current($modified))) ? $modified[0] : $modified;

        // If a manipulation fails and returns a boolean we fallback to the original url
        if(is_bool($modified)) {
            $modified = [
                'url' => $data['url'] ?? ''
            ];
        }

        return FieldtypeOutput::for($this->fieldtype)
            ->value(array_merge($data, $modified))
            ->string($modified['url']);
    }

    protected function callHandler($data, $parameters)
    {
        $method = 'replace_'.$this->attributes['name'];
        $handler = $this->fieldtype->getHandler();

        if ($this->attributes['name'] === 'manipulation') {
            $output = $handler->replace_tag_catchall($data, [], null, current($parameters));

            return is_string($output) ? ['url' => $output] : $output;
        }

        // If the version of ExpressionEngine supports chainable modifiers (7.3+)
        // sending `null` tagdata will give us better results otherwise we will
        // send fake tagdata to force a call to template parser for extra data
        $tagdata = (method_exists($handler, 'getChainableModifiersThatRequireArray')) ? null : '{!-- coilpack:fake --}';

        return $handler->{$method}($data, $parameters, $tagdata);
    }
}
