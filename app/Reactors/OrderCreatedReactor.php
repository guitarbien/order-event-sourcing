<?php

namespace App\Reactors;

use App\Events\OrderCreatedV2;
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
     * @param OrderCreatedV2 $event
     * @param string $aggregateUuid
     */
    public function onOrderCreated(OrderCreatedV2 $event, string $aggregateUuid)
    {
        $order = Order::find($aggregateUuid);

        Mail::to($event->buyer->email)->send(new \App\Mail\OrderCreated($order));
    }
}
