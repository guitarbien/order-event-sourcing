<?php

namespace App\Reactors;

use App\Events\OrderCreated;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

/**
 * Class OrderCreatedReactor
 * @package App\Reactors
 */
final class OrderCreatedReactor implements EventHandler
{
    use HandlesEvents;

    /**
     * @param OrderCreated $event
     * @param string $aggregateUuid
     */
    public function onOrderCreated(OrderCreated $event, string $aggregateUuid)
    {
        $order = Order::find($aggregateUuid);

        Mail::to($event->buyer->email)->send(new \App\Mail\OrderCreated($order));
    }
}
