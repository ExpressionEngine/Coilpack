<?php

namespace Tests\Tag;

use Tests\TestCase;

class ChannelCalendarTest extends TestCase
{
    public function test_channel_calendar()
    {
        $exp = app(\Expressionengine\Coilpack\View\Exp::class);

        $calendar = $exp->channel->calendar(['month' => 10, 'year' => 2022]);
        // this tag needs some heavy work
        // dd($calendar);
    }
}
