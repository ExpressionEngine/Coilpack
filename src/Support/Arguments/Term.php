<?php

namespace Expressionengine\Coilpack\Support\Arguments;

use Illuminate\Support\Str;

class Term
{
    protected $value;

    protected $type;

    protected $wholeWord = false;

    public function __construct($value)
    {
        if (strpos($value, '\W') !== false) {
            $this->wholeWord = true;
            $value = str_replace('\W', '', $value);
        }

        $this->value = trim($value);
    }

    public function addQuery($query, $column, $boolean, $not, $exact)
    {
        if ($not) {
            $operator = $exact ? '!=' : 'NOT LIKE';
        } else {
            $operator = $exact ? '=' : 'LIKE';
        }

        // We also need to take into account 'whole word' matching although the current implementation is MYSQL specific
        // FROM mod.channel.php - _field_search()
        // Note: MySQL's nutty POSIX regex word boundary is [[:>:]]
        // $term = '([[:<:]]|^)' . preg_quote(str_replace('\W', '', $term)) . '([[:>:]]|$)';
        // $search_sql .= ' (' . $col_name . ' ' . $not . ' REGEXP "' . ee()->db->escape_str($term) . '") ';

        $value = $exact ? $this->value : "%{$this->value}%";

        return $query->where($column, $operator, $value, $boolean);
    }

    public function filterCollection($collection, $key, $not, $exact)
    {
        return $collection->filter(function ($item) use ($key, $not, $exact) {
            $value = $item->$key;

            if ($exact) {
                return ($not) ? $value != $this->value : $value == $this->value;
            } else {
                $contains = Str::contains($value, $this->value, true);

                return ($not) ? ! $contains : $contains;
            }
        });
    }

    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
