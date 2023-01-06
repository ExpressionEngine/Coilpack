<?php

namespace Expressionengine\Coilpack\Models\Content;

use Expressionengine\Coilpack\Model;
use ExpressionEngine\Model\Content\FieldModel;
use ExpressionEngine\Service\Model\VariableColumnModel;

/**
 * ExpressionEngine FieldData Model
 */
class FieldData extends VariableColumnModel
{
    protected $primaryKey = 'id';

    protected $table = 'channel_data_field_';

    protected $id;

    protected $entry_id;

    public function forField(FieldModel $field)
    {
        $this->_table_name = $field->getDataTable();

        return $this;
    }
}
