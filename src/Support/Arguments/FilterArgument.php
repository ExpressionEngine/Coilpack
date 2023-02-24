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

        // The boolean logic flips if the argument is negated
        if ($this->not) {
            $this->boolean = ($this->boolean === 'or') ? 'and' : 'or';
        }

        $terms = array_filter(explode($this->separator, $value), function ($term) {
            return ! is_null($term) && trim($term) !== '';
        });

        $this->terms = collect();

        foreach ($terms as $term) {
            $this->terms->push(TermFactory::make($term));
        }
    }

    public function addQuery($query, $column, $not = null)
    {
        if (! $query instanceof Builder && ! $query instanceof EloquentBuilder) {
            return $query;
        }

        $not = is_null($not) ? $this->not : $not;

        return $query->where(function ($query) use ($column, $not) {
            $this->terms->each(function ($term) use ($query, $column, $not) {
                $term->addQuery($query, $column, $this->boolean, $not, $this->exact);
            });
        });
    }

    public function addRelationshipQuery($query, $relationship, $column)
    {
        $operator = $this->not ? '<' : '>=';
        $count = 1;

        return $query->has($relationship, $operator, $count, 'and', function ($query) use ($column) {
            // We are handling the negation on our relationship query
            // so we just want to use non-negated where clauses
            return $this->addQuery($query, $column, false);
        });
    }
}
