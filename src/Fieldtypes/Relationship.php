<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\FieldtypeOutput;
use Expressionengine\Coilpack\Models\Channel\ChannelField;
use Expressionengine\Coilpack\Models\FieldContent;
use ExpressionEngine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Illuminate\Support\Facades\DB;

class Relationship extends Fieldtype implements ListsGraphType
{

    public function apply(FieldContent $content, $parameters = [])
    {
        // $fields = $content->entry->relationships->where('grid_id', $content->field->id);
        $data = $this->loadData($content);
        return FieldtypeOutput::make($data);
    }

    protected function loadData(FieldContent $content)
    {
        $isGrid = $content->field->field_name === 'grid';
        $isFluid = isset($content->fluid_field);

        $query = ChannelEntry::query()
            ->select('channel_titles.*')
            ->join('relationships', 'entry_id', '=', 'child_id')
            ->when($isFluid, function($query) use($content) {
                $query->where('relationships.fluid_field_data_id', $content->fluid_order);
            })
            ->when($isGrid, function ($query) use ($content) {
                $query->where('relationships.parent_id', $content->entry_id)
                ->where('relationships.grid_field_id', $content->field->field_id)
                ->where('relationships.grid_row_id', $content->grid_row_id)
                ->where('relationships.grid_col_id', $content->grid_col_id);
            }, function($query) use($content) {
                $query->where('relationships.parent_id', $content->entry_id)
                ->where('relationships.field_id', $content->field->field_id);
            })
            ->orderBy('order');

        $data = $query->get();
        return $data;
    }

    public function graphType()
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('ChannelEntry');

        return \GraphQL\Type\Definition\Type::listOf(
            \Rebing\GraphQL\Support\Facades\GraphQL::type('ChannelEntry')
        );
    }
}
