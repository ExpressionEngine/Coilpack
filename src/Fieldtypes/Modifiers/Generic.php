<?php

namespace Expressionengine\Coilpack\Fieldtypes\Modifiers;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Modifier;
use Expressionengine\Coilpack\Models\FieldContent;

class Generic extends Modifier
{
    protected function callHandler($data, $parameters)
    {
        $method = 'replace_'.$this->attributes['name'];
        $handler = $this->fieldtype->getHandler();

        return $handler->{$method}($data, $parameters);
    }

    public function handle(FieldContent $content, $parameters = [])
    {
        $modified = $this->callHandler($content->data, $parameters);

        return FieldtypeOutput::make($modified);
    }
}
