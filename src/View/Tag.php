<?php

namespace Expressionengine\Coilpack\View;

use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;

abstract class Tag implements \Stringable
{
    use HasArgumentsAndParameters;

    /**
     * Run the tag logic to produce the output
     *
     * @return mixed
     */
    abstract public function run();

    /**
     * Process this tag with the provided arguments
     *
     * @param  array  $arguments
     * @return mixed
     */
    public function __invoke($arguments = [])
    {
        return $this->arguments($arguments)->run();
    }

    /**
     * Cast the tag to a string by invoking the run method
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->run();
    }
}
