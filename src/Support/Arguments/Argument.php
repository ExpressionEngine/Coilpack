<?php

namespace Expressionengine\Coilpack\Support\Arguments;

class Argument
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
