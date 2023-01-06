<?php

namespace Tests\Fieldtype;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class GridTest extends TestCase
{
    public function test_grid()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_grid->value();
        $this->assertEquals([
            'one',
            'two',
            'three',
        ], array_map(function ($row) {
            return (string) $row->test_grid_col;
        }, $output->toArray()));
    }

    public function test_grid_with_parameters()
    {
        $entry = ChannelEntry::where('title', 'Test Fieldtypes')->first();

        $output = $entry->test_grid->parameters(['sort' => 'desc', 'limit' => 2]);
        $this->assertEquals([
            'three',
            'two',
        ], array_map(function ($row) {
            return (string) $row->test_grid_col;
        }, $output->toArray()));

        $output = $entry->test_grid->parameters(['row_id' => '1|3']);
        $this->assertEquals([
            'one',
            'three',
        ], array_map(function ($row) {
            return (string) $row->test_grid_col;
        }, $output->toArray()));
    }

    /*
    public function setup()
    {
        // Create Field
        // dd(ee()->config,
        //     'here'
        // );
        // $field = ee('Model')->make('ChannelField');
        // $field->set([
        //     'site_id' => 1,
        //     'field_name' => 'test_grid',
        //     'field_label' => 'Test Grid',
        //     'field_type' => 'grid',
        //     'field_list_items' => '',
        //     'field_order' => 99,
        //     'grid' => [
        //         'cols' => [
        //             [
        //                 'col_name' => 'Test Grid Text',
        //                 'col_label' => 'test_grid_text',
        //                 'col_type' => 'text',
        //             ]
        //         ]
        //     ]
        // ]);
        // $field->save();

        // Create Channel and Attach Field
        // $channel = ee('Model')->make('Channel');
        // Create Entry with Data

        // Assert Coilpack Tag is working
    }
    */
}
