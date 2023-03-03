<?php

namespace Tests\Graphql;

use Tests\TestCase;

class CategoriesTest extends TestCase
{
    public function test_categories()
    {
        $this->postJson('graphql', [
            'query' => <<<'GQL'
            {
                exp_channel_categories {
                    cat_id,
                    cat_name
                }
            }
          GQL
        ])
        ->assertJsonFragment(['cat_id' => 2]);

        $this->postJson('graphql', [
            'query' => <<<'GQL'
            {
                exp_channel_categories(category_id: "2") {
                    cat_id,
                    cat_name
                }
            }
          GQL
        ])
        ->assertJsonFragment(['cat_id' => 2]);
    }
}
