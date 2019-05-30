<?php

namespace App\Reactors;

use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

final class OrderDeliveredReactor implements EventHandler
{
    use HandlesEvents;

    public function onEventHappened(EventHappended $event)
    {
    }
}
