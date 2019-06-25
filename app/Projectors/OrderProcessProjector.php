<?php

namespace App\Projectors;

use App\Events\OrderArrived;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Exceptions\CouldNotChangeStatus;
use App\Order;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use Spatie\EventProjector\Projectors\QueuedProjector;

/**
 * Class OrderProcessProjector
 * @package App\Projectors
 */
final class OrderProcessProjector implements QueuedProjector
{
    use ProjectsEvents;

    /**
     * @param OrderPicked $event
     * @param string $aggregateUuid
     */
    public function onOrderPicked(OrderPicked $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);

        if ($order === null) {
            throw CouldNotChangeStatus::orderNotFound();
        }

        if (!$order->picked) {
            $order->pickedAt($event->pickedAt);
        }
    }

    /**
     * @param OrderPrepared $event
     * @param string $aggregateUuid
     */
    public function onOrderPrepared(OrderPrepared $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);

        if ($order === null) {
            throw CouldNotChangeStatus::orderNotFound();
        }

        if (!$order->prepared) {
            $order->preparedAt($event->preparedAt);
        }
    }

    /**
     * @param OrderDelivered $event
     * @param string $aggregateUuid
     */
    public function onOrderDelivered(OrderDelivered $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);

        if ($order === null) {
            throw CouldNotChangeStatus::orderNotFound();
        }

        if (!$order->delivered) {
            $order->deliveredAt($event->deliveredAt);
        }
    }

    /**
     * @param OrderArrived $event
     * @param string $aggregateUuid
     */
    public function onOrderArrived(OrderArrived $event, string $aggregateUuid)
    {
        $order = Order::uuid($aggregateUuid);

        if ($order === null) {
            throw CouldNotChangeStatus::orderNotFound();
        }

        if (!$order->arrived) {
            $order->arrivedAt($event->arrivedAt);
        }
    }
}
