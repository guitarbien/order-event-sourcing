<?php

namespace App\Reactors;

use App\Events\OrderDelivered;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

/**
 * Class OrderDeliveredReactor
 * @package App\Reactors
 */
final class OrderDeliveredReactor implements EventHandler
{
    use HandlesEvents;

    /**
     * @param OrderDelivered $event
     * @param string $aggregateUuid
     */
    public function onOrderDelivered(OrderDelivered $event, string $aggregateUuid)
    {
        $order = Order::find($aggregateUuid);

        Mail::to($order->contact_email)->send(new \App\Mail\OrderDelivered($order));
    }
}
