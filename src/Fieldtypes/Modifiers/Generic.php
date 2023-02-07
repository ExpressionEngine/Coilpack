<?php

namespace Expressionengine\Coilpack\Fieldtypes\Modifiers;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Fieldtypes\Modifier;

// use Expressionengine\Coilpack\Models\FieldContent;

class Generic extends Modifier
{
    protected function callHandler($data, $parameters)
    {
        $method = 'replace_'.$this->attributes['name'];
        $handler = $this->fieldtype->getHandler();

        return $handler->{$method}((string) $data, $parameters);
    }

    public function handle(FieldtypeOutput $content, $parameters = [])
    {
        $modified = $this->callHandler($content, $parameters);

        return FieldtypeOutput::for($this->fieldtype)->value($modified);
    }
}
