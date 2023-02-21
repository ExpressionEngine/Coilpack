<?php

namespace Expressionengine\Coilpack\Support\Arguments;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

class FilterArgument extends Argument
{
    protected $value;

    protected $not = false;

    protected $exact = true;

    protected $boolean = 'or';

    protected $separator = '|';

    protected $terms;

    public function __construct($value)
    {
        $this->value = (string) $value;
        $this->parse($value);
    }

    protected function parse($value)
    {
        // Check for a negated set
        if (strncasecmp($value, 'not ', 4) == 0) {
            $this->not = true;
            $value = substr($value, 4);
        }

        // Check for set joined by logical and
        if (strpos($value, '&&')) {
            $this->separator = '&&';
            $this->boolean = 'and';
        }

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

        $query->where(function ($query) use ($column) {
            $this->terms->each(function ($term) use ($query, $column) {
                $term->addQuery($query, $column, $this->boolean, $this->not, $this->exact);
            });
        });

        return $query;
    }
}
