<?php

namespace Expressionengine\Coilpack\View;

abstract class ModelTag extends IterableTag
{
    protected $query;

    protected $takeFirst = false;

    public function setLimitArgument($count)
    {
        $this->query->take($count);

        if ($count == 1) {
            $this->takeFirst = true;
        }

        return $count;
    }

    public function run()
    {
        if ($this->hasArgument('paginate')) {
            return $this->query->paginate($this->getArgument('paginate'));
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
