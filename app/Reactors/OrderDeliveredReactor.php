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

    protected $handlesEvents = [
        OrderDelivered::class => 'onOrderDelivered',
    ];

    /**
     * @param OrderDelivered $event
     * @param string $storedEvent
     */
    public function onOrderDelivered(OrderDelivered $event, string $storedEvent)
    {
        $uuid = json_decode($storedEvent, true)['aggregate_uuid'];

        $order = Order::find($uuid);

        Log::info(vsprintf('Hi %s, your order %s was delivered at: %s', [
            $order->contact_name,
            $uuid,
            $event->deliveredAt
        ]));
    }
}
