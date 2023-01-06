<?php

namespace Tests\Graphql;

use Tests\TestCase;

class VariablesTest extends TestCase
{
    public function test_variables()
    {
        $this->postJson('graphql', [
            'query' => <<<'GQL'
            {
                variables {
                    global {
                        group_title
                    }
                    site_name
                }
            }
          GQL
        ])
            ->assertJsonFragment(['group_title' => 'Guests'])
            ->assertJsonFragment(['site_name' => 'Default Site']);
    }
}
