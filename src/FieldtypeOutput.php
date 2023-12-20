<?php

namespace Expressionengine\Coilpack;

use Expressionengine\Coilpack\Fieldtypes\Fieldtype;

class FieldtypeOutput extends TemplateOutput
{
    protected $fieldtype = null;

    public static function for(Fieldtype $fieldtype)
    {
        $instance = new static;

        $instance->fieldtype = $fieldtype;

        return $instance;
    }

    public function hasModifier($method)
    {
        return $this->fieldtype->hasModifier($method);
    }

    public function callModifier(string $name, $parameters = [])
    {
        return $this->fieldtype->callModifier($this, $name, is_array($parameters) ? $parameters : [$parameters]);
    }

    public function __call($method, $arguments)
    {
        if ($this->hasModifier($method)) {
            return $this->callModifier($method, ...$arguments);
        }

        return $this->object->{$method}(...$arguments);
    }
}
