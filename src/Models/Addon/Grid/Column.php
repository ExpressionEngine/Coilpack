<?php

namespace Expressionengine\Coilpack\Models\Addon\Grid;

use Expressionengine\Coilpack\Model;

class Column extends Model {

    protected $table = 'grid_columns';

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

}