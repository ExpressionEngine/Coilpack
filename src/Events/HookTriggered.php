<?php

namespace Expressionengine\Coilpack\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class HookTriggered
{
    use Dispatchable, InteractsWithSockets;

    /**
     * The hook name.
     *
     * @var string
     */
    public $name;

    /**
     * The hook status.
     *
     * @var bool
     */
    public $isActive;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct($name, $isActive)
    {
        $this->name = $name;
        $this->isActive = $isActive;
    }
}
