<?php


namespace Expressionengine\Coilpack\Models\Content;

use ExpressionEngine\Service\Model\Gateway;

/**
 * Content Variable Column Gateway
 */
class VariableColumnGateway extends Gateway
{
    /**
     *
     */
    public function getFieldList($cached = true)
    {
        if ($cached && isset($this->_field_list_cache)) {
            return $this->_field_list_cache;
        }

        $all = ee('Database')
            ->newQuery()
            ->list_fields($this->getTableName());

        $known = parent::getFieldList();

        return $this->_field_list_cache = array_merge($known, $all);
    }
}


