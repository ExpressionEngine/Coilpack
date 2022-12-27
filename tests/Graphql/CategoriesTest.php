<?php

namespace Tests\Graphql;

use Tests\TestCase;

class CategoriesTest extends TestCase
{

    public function test_categories()
    {
        $this->postJson('graphql', [
            'query' => <<<GQL
            {
                categories {
                    cat_id,
                    cat_name
                }
            }
          GQL
        ])
        ->assertJsonFragment(['cat_id' => 2]);
    }

}
