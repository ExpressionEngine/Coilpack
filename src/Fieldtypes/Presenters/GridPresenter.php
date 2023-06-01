<?php

namespace Expressionengine\Coilpack\Fieldtypes\Presenters;

use Expressionengine\Coilpack\FieldtypeManager;
use Expressionengine\Coilpack\Models\FieldContent;
use Expressionengine\Coilpack\Support\Arguments\FilterArgument;
use Expressionengine\Coilpack\Support\Arguments\ListArgument;
use Expressionengine\Coilpack\Support\Arguments\SearchArgument;
use Expressionengine\Coilpack\Support\Parameter;
use Expressionengine\Coilpack\Traits\HasArgumentsAndParameters;
use Illuminate\Support\Facades\DB;

class GridPresenter extends Presenter
{
    use HasArgumentsAndParameters;

    public function present(FieldContent $content, $arguments)
    {
        if (! $content->hasAttribute('entry_id')) {
            return [];
        }

        $isFluid = $content->hasAttribute('fluid_field');
        $this->arguments($arguments);

        $data = $content->entry->isPreview() ? $this->loadFromPreview($content) : $this->loadFromDatabase($content);

        $columns = $content->field->gridColumns;

        // maybe we want to persist $data from the query before we do any filtering?
        $data = $data->filter(function ($row) use ($isFluid, $content) {
            return ! $isFluid || $row->fluid_field_data_id == $content->fluid_field_data_id;
        })->map(function ($row) use ($columns, $content) {
            $columns->each(function ($column) use ($row, $content) {
                $row->{$column->col_name} = new FieldContent(
                    array_merge($content->getAttributes(), [
                        'data' => $row->{'col_id_'.$column->col_id},
                        'grid_row_id' => $row->row_id,
                        'grid_col_id' => $column->col_id,
                        'fieldtype' => app(FieldtypeManager::class)->make($column->col_type),
                    ])
                );
            });

            return $row;
        });

        return $data;
    }

    protected function loadFromPreview($content)
    {
        $isFluid = $content->hasAttribute('fluid_field');
        $fluidFieldId = ($isFluid) ? $content->fluid_field_data_id : 0;

        $rows = collect($content->data['rows'] ?? [])->map(function ($value, $key) use ($fluidFieldId) {
            $id = str_replace('row_id_', '', $key);

            return (object) array_merge([
                'row_id' => $id,
                'fluid_field_data_id' => $fluidFieldId,
            ], $value);
        });

        // Filter by row ids
        if ($this->hasArgument('row_id')) {
            $rows = $this->getArgument('row_id')->filterCollection($rows, 'row_id');
        }

        // Search
        if ($this->hasArgument('search')) {
            $columns = $content->field->gridColumns->pluck('col_id', 'col_name');
            foreach ($this->getArgument('search') as $field => $argument) {
                if ($columns->has($field)) {
                    $column = 'col_id_'.$columns[$field];
                    $rows = $argument->filterCollection($rows, $column);
                }
            }
        }

        // fixed_order
        if ($this->hasArgument('fixed_order')) {
            $ordered = collect();
            $this->getArgument('fixed_order')->terms->each(function ($term) use ($rows, $ordered) {
                $id = $term->value;
                $row = $rows->first(function ($row) use ($id) {
                    return $row->row_id == $id;
                });

                if ($row) {
                    $ordered->push($row);
                }
            });
            $rows = $ordered;
        } else {
            $rows = ($this->getArgument('sort')->value == 'asc')
                ? $rows->sortBy($this->getArgument('orderby')->value)
                : $rows->sortByDesc($this->getArgument('orderby')->value);
        }

        // Handle offset
        if ($this->hasArgument('offset')) {
            $rows = $rows->skip($this->getArgument('offset')->value);
        }

        $rows = $rows->take($this->getArgument('limit')->value);

        return $rows;
    }

    protected function loadFromDatabase(FieldContent $content)
    {
        $isFluid = $content->hasAttribute('fluid_field');
        $fluidFieldId = ($isFluid) ? $content->fluid_field_data_id : 0;

        $tableName = "channel_grid_field_{$content->field->field_id}";
        $query = DB::connection('coilpack')
            ->table($tableName)
            ->where('entry_id', $content->entry_id)
            ->where('fluid_field_data_id', '=', $fluidFieldId); // $fluidFieldId);

        // Handle ordering
        if ($this->hasArgument('fixed_order')) {
            $fixedOrder = $this->getArgument('fixed_order');
            $query->whereIn('row_id', $fixedOrder);
            $query->orderByRaw('FIELD(row_id, '.implode(',', $fixedOrder).')');
        } else {
            $direction = ($this->getArgument('sort')->value == 'asc') ? 'asc' : 'desc';
            $query->orderBy($this->getArgument('orderby')->value, $direction);
        }

        // Filter by row ids
        if ($this->hasArgument('row_id')) {
            $this->getArgument('row_id')->addQuery($query, 'row_id');
        }

        // Search
        if ($this->hasArgument('search')) {
            $columns = $content->field->gridColumns->pluck('col_id', 'col_name');
            foreach ($this->getArgument('search') as $field => $argument) {
                if ($columns->has($field)) {
                    $column = 'col_id_'.$columns[$field];
                    $argument->addQuery($query, $column);
                }
            }
        }

        // Handle offset
        if ($this->hasArgument('offset')) {
            $query->skip($this->getArgument('offset')->value);
        }

        $data = $query->take($this->getArgument('limit')->value)->get();

        return $data;
    }

    public function getArgumentFallback($key, $value)
    {
        return new FilterArgument($value);
    }

    public function getFixedOrderArgument($order)
    {
        return new ListArgument($order);
    }

    public function getSearchArgument($search)
    {
        foreach ($search as $field => $value) {
            $search[$field] = new SearchArgument($value);
        }

        return $search;
    }

    public function defineParameters(): array
    {
        return [
            new Parameter([
                'name' => 'fixed_order',
                'type' => 'string',
                'description' => 'Order rows in a fixed order of row IDs',
            ]),
            new Parameter([
                'name' => 'limit',
                'type' => 'integer',
                'description' => 'Limits the number of rows',
                'defaultValue' => 100,
            ]),
            new Parameter([
                'name' => 'offset',
                'type' => 'integer',
                'description' => 'Offsets the number of rows',
                'defaultValue' => 0,
            ]),
            new Parameter([
                'name' => 'orderby',
                'type' => 'string',
                'description' => 'Order rows by a specific column',
                'defaultValue' => 'row_order',
            ]),
            new Parameter([
                'name' => 'row_id',
                'type' => 'string',
                'description' => 'Only rows for the given IDs. Multiple rows may be specified by separating them with a pipe character',
            ]),
            new Parameter([
                'name' => 'sort',
                'type' => 'string',
                'description' => 'Specifies the direction of the sorting',
                'defaultValue' => 'asc',
            ]),
        ];
    }
}
