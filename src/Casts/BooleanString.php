<?php

namespace Expressionengine\Coilpack\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class BooleanString implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return $this->isTruthy($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return ($this->isTruthy($value)) ? 'y' : 'n';
    }

    /**
     * Our ee-aware truthyness check
     */
    private function isTruthy($value)
    {
        return ($value === true || $value === 'y' || $value === 1);
    }
}
