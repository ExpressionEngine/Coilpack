<?php

namespace Expressionengine\Coilpack\Support\Arguments;

class NumericTerm extends Term
{
    public static $operators = [
        '>', '<', '>=', '<=',
    ];

    protected $operator = '=';

    public function __construct($value)
    {
        $operator = null;
        $operators = static::$operators;

        while ($operators && ! $operator) {
            $find = array_pop($operators);

            if (strpos($value, $find) !== false) {
                $operator = $find;
                $value = str_replace($find, '', $value);
            }
        }

        // Convert $value to a numeric type
        parent::__construct($value + 0);
    }

    public function addQuery($query, $column, $boolean, $not, $exact)
    {
        return $query->where($column, $this->operator, $this->value, $boolean);
    }
}
