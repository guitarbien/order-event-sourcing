<?php

namespace App\Reactors;

use App\Events\OrderDelivered;
use App\Order;
use Illuminate\Support\Facades\Log;
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

        Log::info(vsprintf('Hi %s, your order %s was delivered at: %s', [
            $order->contact_name,
            $aggregateUuid,
            $event->deliveredAt
        ]));
    }
}
