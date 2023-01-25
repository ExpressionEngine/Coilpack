<?php

namespace Expressionengine\Coilpack\View;

abstract class ModelTag extends IterableTag
{
    protected $query;

    protected $takeFirst = false;
    // abstract protected function query

    public function run()
    {
        if ($this->hasParameter('paginate')) {
            return $this->query->paginate($this->getParameter('paginate'));
        } elseif ($this->takeFirst) {
            return $this->query->first();
        }

        return $this->query->get();
    }

    public function __call($method, $arguments)
    {
        $result = $this->query->{$method}(...$arguments);

        if ($result instanceof $this->query) {
            return $this;
        }

        return $result;
    }
}
