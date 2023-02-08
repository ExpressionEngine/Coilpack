<?php

namespace Expressionengine\Coilpack\View;

class TagProxy
{
    private $tags = [];

    private $fallback;

    public function __construct($tags, $fallback = null)
    {
        $this->tags = $tags;
        $this->fallback = $fallback;
    }

    public function __get($key)
    {
        if ($this->hasTag($key)) {
            return $this->getTag($key);
        }

        return ($this->fallback) ? $this->fallback->$key : null;
    }

    public function __call($method, $arguments)
    {
        if ($this->hasTag($method)) {
            return $this->getTag($method)->arguments($arguments[0])->run();
        }

        return ($this->fallback) ? $this->fallback->$method($arguments[0]) : null;
    }

    protected function getTag($tag)
    {
        if (! $this->hasTag($tag)) {
            return null;
        }
        // Check that the class extends \Expressionengine\Coilpack\View\Tag
        return $this->hasNestedTag($tag) ? new static($this->tags[$tag]) : new $this->tags[$tag];
    }

    protected function hasTag($tag)
    {
        return array_key_exists(strtolower($tag), $this->tags);
    }

    protected function hasNestedTag($tag)
    {
        return $this->hasTag($tag) && is_array($this->tags[$tag]);
    }

    public function __isset($key)
    {
        return true;

        return $this->hasTag($key);
    }
}
