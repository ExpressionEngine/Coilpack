<?php

namespace Expressionengine\Coilpack\Fieldtypes;

use Expressionengine\Coilpack\Contracts\Field;
use Expressionengine\Coilpack\Contracts\ListsGraphType;
use Expressionengine\Coilpack\FieldtypeOutput;
use ExpressionEngine\Coilpack\Models\Channel\ChannelEntry;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Parameter;

class Relationship extends Fieldtype implements ListsGraphType
{
    public function apply(FieldContent $content, $parameters = [])
    {
        // $fields = $content->entry->relationships->where('grid_id', $content->field->id);
        $data = $this->loadData($content);

        return FieldtypeOutput::for($this)->value($data);
    }

    protected function loadData(FieldContent $content)
    {
        $isGrid = $content->field->field_type === 'grid';
        $isFluid = $content->hasAttribute('fluid_field');
        $fluidFieldId = ($isFluid) ? $content->fluid_field_data_id : 0;

        $query = ChannelEntry::query();

        if (ee('LivePreview')->hasEntryData()) {
            $query->whereIn('entry_id', $content->data['data'] ?? [0]);
        } else {
            $query->select('channel_titles.*')
                ->join('relationships', 'entry_id', '=', 'child_id')
                ->when($isFluid, function ($query) use ($fluidFieldId) {
                    $query->where('relationships.fluid_field_data_id', $fluidFieldId);
                })
                ->when($isGrid, function ($query) use ($content) {
                    $query->where('relationships.parent_id', $content->entry_id)
                        ->where('relationships.grid_field_id', $content->field->field_id)
                        ->where('relationships.grid_row_id', $content->grid_row_id)
                        ->where('relationships.grid_col_id', $content->grid_col_id);
                }, function ($query) use ($content) {
                    $query->where('relationships.parent_id', $content->entry_id)
                        ->where('relationships.field_id', $content->field->field_id);
                })
                ->orderBy('order');
        }

        $data = $query->get();

        return $data;
    }

    public function parameters(Field $field = null): array
    {
        return [
            new Parameter([
                'name' => 'author_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Member ID',
            ]),
            new Parameter([
                'name' => 'category',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Category ID',
            ]),
            new Parameter([
                'name' => 'channel',
                'type' => 'string',
                'description' => 'From which channel to show the entries',
            ]),
            new Parameter([
                'name' => 'entry_id',
                'type' => 'string',
                'description' => 'Limit the entries to the specified Entry ID',
            ]),
            new Parameter([
                'name' => 'group_id',
                'type' => 'string',
                'description' => 'Limit entries to the specified Member Role ID',
            ]),
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of entries',
            ]),
            new Parameter([
                'name' => 'offset',
                'type' => 'integer',
                'description' => 'Offsets the display by X number of entries',
            ]),
            new Parameter([
                'name' => 'orderby',
                'type' => 'string',
                'description' => 'Sets the display order of the entries',
            ]),
            new Parameter([
                'name' => 'show_expired',
                'type' => 'boolean',
                'description' => 'Include expired entries',
            ]),
            new Parameter([
                'name' => 'show_future_entries',
                'type' => 'boolean',
                'description' => 'Include entries that have a date in the future',
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'The sort order (asc/desc)',
            ]),
            new Parameter([
                'name' => 'start_on',
                'type' => 'string',
                'description' => 'A particular date/time on which to start the entries',
            ]),
            new Parameter([
                'name' => 'status',
                'type' => 'string',
                'description' => 'Restrict to entries with a particular status',
            ]),
            new Parameter([
                'name' => 'stop_before',
                'type' => 'string',
                'description' => 'A particular date/time on which to stop the entries',
            ]),
            new Parameter([
                'name' => 'url_title',
                'type' => 'string',
                'description' => 'Limits the query by an entry’s url_title',
            ]),
            new Parameter([
                'name' => 'username',
                'type' => 'string',
                'description' => 'Limits the query by username',
            ]),
        ];
    }

    public function graphType()
    {
        return 'ChannelEntry';
    }
}
