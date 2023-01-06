<?php

namespace Expressionengine\Coilpack\View;

class MissingTag
{
    public function __construct($tags)
    {
        $this->tags = $tags;
    }

    public function __get($key)
    {
        return $this;
    }

    public function __call($method, $args)
    {
        return $this;
    }

    public function __isset($key)
    {
        return true;
    }
}
