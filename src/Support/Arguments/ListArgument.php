<?php

namespace Expressionengine\Coilpack\Support\Arguments;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

class ListArgument extends Argument
{
    protected $value;

    protected $separator = '|';

    protected $terms;

    public function __construct($value)
    {
        $this->value = (string) $value;
        $this->parse($value);
    }

    protected function parse($value)
    {
        $terms = array_filter(explode($this->separator, $value), function ($term) {
            return ! is_null($term) && trim($term) !== '';
        });

        $this->terms = collect();

        foreach ($terms as $term) {
            $this->terms->push(TermFactory::make($term));
        }
    }

    public function addQuery($query, $column)
    {
        if (! $query instanceof Builder && ! $query instanceof EloquentBuilder) {
            return $query;
        }

        $query->whereIn($column, $this->terms->pluck('value')->toArray());

        return $query;
    }
}
