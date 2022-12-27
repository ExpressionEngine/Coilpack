<?php

namespace Expressionengine\Coilpack\View;

class FilteredParameterValue
{

    protected $attributes;

    public function __construct($value)
    {
        $this->attributes = array_merge(
            ['original' => $value],
            $this->categorize($this->normalize($value))
        );
    }

    public function hasIncludes()
    {
        return !empty($this->includes());
    }

    public function hasExcludes()
    {
        return !empty($this->excludes());
    }

    public function includes()
    {
        return $this->attributes['include'];
    }

    public function excludes()
    {
        return $this->attributes['exclude'];
    }

    public function filterQueryWithColumn($query, $column)
    {
        return $query->when($this->hasIncludes(), function ($query) use ($column) {
            $query->whereIn($column, $this->includes());
        })->when($this->hasExcludes(), function ($query) use ($column) {
            $query->whereNotIn($column, $this->excludes());
        });
    }

    public function original()
    {
        return $this->attributes['original'];
    }

    protected function normalize($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (str_contains($value, '|')) {
            return explode('|', $value);
        }

        return [$value];
    }

    protected function categorize(array $values)
    {
        return array_reduce($values, function($carry, $value) {
            if(strpos($value, 'not ') === 0) {
                array_push($carry['exclude'], substr($value, 4));
            }else{
                array_push($carry['include'], $value);
            }

            return $carry;
        }, [
            'include' => [],
            'exclude' => [],
        ]);
    }




}