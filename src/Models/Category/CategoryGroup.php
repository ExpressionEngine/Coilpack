<?php

namespace Expressionengine\Coilpack\Models\Category;

use Expressionengine\Coilpack\Model;

/**
 * Category Group Model
 */
class CategoryGroup extends Model
{
    protected $primaryKey = 'group_id';

    protected $table = 'category_groups';

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function fields()
    {
        return $this->hasMany(CategoryField::class);
    }
}
