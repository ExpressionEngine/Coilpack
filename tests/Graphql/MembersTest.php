<?php

namespace Tests\Graphql;

use Tests\TestCase;

class MembersTest extends TestCase
{
    public function test_members_me()
    {
        $this->postJson('graphql', [
            'query' => <<<'GQL'
            {
                me {
                    member_id
                    screen_name
                }
            }
          GQL
        ])
            ->assertJsonFragment(['member_id' => null])
            ->assertJsonFragment(['screen_name' => 'Guest']);
    }
}
