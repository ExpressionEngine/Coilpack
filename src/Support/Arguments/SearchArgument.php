<?php

namespace Expressionengine\Coilpack\Support\Arguments;

class SearchArgument extends FilterArgument
{
    protected $exact = false;

    public function __construct($value)
    {
        $this->value = (string) $value;
        $this->parse($value);
    }

    protected function parse($value)
    {
        // Check for exact match
        if (strncasecmp($value, '=', 1) == 0) {
            $this->exact = true;
            $value = substr($value, 1);
        }

        return parent::parse($value);
    }
}
