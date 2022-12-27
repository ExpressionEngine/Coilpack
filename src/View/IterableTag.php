<?php

namespace Expressionengine\Coilpack\View;

use IteratorAggregate;
use Traversable;

abstract class IterableTag extends Tag implements IteratorAggregate
{
    public function getIterator(): Traversable
    {
        return $this->run();
    }
}
