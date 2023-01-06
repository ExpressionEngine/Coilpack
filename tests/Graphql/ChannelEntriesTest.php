<?php

namespace Tests\Graphql;

use Expressionengine\Coilpack\Models\Channel\ChannelEntry;
use Tests\TestCase;

class ChannelEntriesTest extends TestCase
{

    public function test_entries()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about"){
                    entry_id
                    title
                    sticky
                    entry_date(format: "Y-m-d")
                }
            }
          GQL
        ])
        ->assertJsonFragment(['entry_id' => 2])
        ->assertJsonFragment(['entry_date' => '2022-10-20'])
        ->assertJsonFragment(['title' => 'About Default Theme']);
    }

    public function test_entries_author()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about"){
                    entry_id
                    author {
                        screen_name
                    }
                }
            }
          GQL
        ])
        ->assertJsonFragment(['screen_name' => 'admin']);
    }

    public function test_entries_channel()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about"){
                    entry_id
                    channel {
                        channel_title
                        channel_description
                        channel_id
                    }
                }
            }
          GQL
        ])
            ->assertJsonFragment(['channel_title' => 'About']);
    }

    public function test_entries_categories()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"blog"){
                    entry_id
                    categories {
                        cat_id
                        cat_name
                        cat_description
                    }
                }
            }
          GQL
        ])
            ->assertJsonFragment(['cat_name' => 'News']);
    }

    public function test_entries_grid_field()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about" limit:1){
                    entry_id
                    about_image {
                        image {
                            directory_id
                            width
                            height
                            url
                            path
                            file_size_human_long
                            file_size_human
                        }
                        caption
                        align
                    }
                }
            }
          GQL
        ])
            ->assertJsonFragment(['caption' => 'Dharmafrog, 2014']);
    }

    public function test_entries_grid_field_image_modifier()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about" limit:1){
                    entry_id
                    about_image {
                        image(resize: {width:100}) {
                            url
                            width
                            height
                        }
                        caption
                        align
                    }
                }
            }
          GQL
        ])
        ->assertJsonFragment(['caption' => 'Dharmafrog, 2014'])
        ->assertJsonFragment(['width' => 100]);
    }

    public function test_entries_relationship()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(title:"Test Fieldtypes" limit:1){
                    entry_id
                    test_relationships {
                        title
                        blog_audio {
                            id
                            type
                        }
                    }
                }
            }
          GQL
        ])
        ->assertJsonFragment(['title' => 'Entry with SoundCloud audio'])
        ->assertJsonFragment(['id' => '164768245'])
        ->assertJsonFragment(['type' => 'soundcloud']);
    }

    public function test_entries_text_field_modifier()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                channel_entries(channel:"about"){
                    entry_id
                    title
                    author {
                    screen_name
                    }
                    page_content(length:true)
                }
            }
          GQL
        ])
            ->assertJsonFragment(['page_content' => "4461"]);
    }

}
