<?php

namespace Expressionengine\Coilpack\Contracts;

interface ConvertsToGraphQL
{
    public function toGraphQL(): array;
}
