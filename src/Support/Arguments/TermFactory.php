<?php

namespace Expressionengine\Coilpack\Support\Arguments;

use Illuminate\Support\Str;

class TermFactory
{
    public static function make($value)
    {
        if (Str::contains($value, NumericTerm::$operators)) {
            return new NumericTerm($value);
        } elseif ($value == EmptyTerm::$identifier) {
            return new EmptyTerm($value);
        }

        return new Term($value);
    }
}
