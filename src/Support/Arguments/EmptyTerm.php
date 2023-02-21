<?php

namespace Expressionengine\Coilpack\Support\Arguments;

class EmptyTerm extends Term
{
    public static $identifier = 'IS_EMPTY';

    public function addQuery($query, $column, $boolean, $not, $exact)
    {
        return $query->whereNull($column, $boolean, $not);
    }
}
