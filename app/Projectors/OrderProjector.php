<?php

namespace App\Projectors;

use App\Events\OrderArrived;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Order;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class OrderProjector implements Projector
{
    use ProjectsEvents;

    public function onOrderCreated(OrderCreated $event)
    {
        Order::create([
            'id'              => $event->orderUuid,
            'contact_name'    => $event->contactName,
            'contact_address' => $event->contactAddress,
            'contact_mobile'  => $event->contactMobile,
        ]);
    }

    public function onOrderPicked(OrderPicked $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);
        $order->pickedAt($event->pickedAt);
    }

    public function onOrderPrepared(OrderPrepared $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);
        $order->preparedAt($event->preparedAt);
    }

    public function onOrderDelivered(OrderDelivered $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);
        $order->deliveredAt($event->deliveredAt);
    }

    public function onOrderArrived(OrderArrived $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);
        $order->arrivedAt($event->arrivedAt);
    }
}
