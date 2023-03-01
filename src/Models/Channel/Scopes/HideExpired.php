<?php

namespace Expressionengine\Coilpack\Models\Channel\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HideExpired implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function ($query) {
            $query->where('expiration_date', 0)
                ->orWhere('expiration_date', '>', now()->timestamp);
        });
    }
}
