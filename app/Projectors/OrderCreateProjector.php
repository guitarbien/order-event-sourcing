<?php

namespace App\Projectors;

use App\Events\OrderCreated;
use App\Order;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class OrderCreateProjector implements Projector
{
    use ProjectsEvents;

    public function onOrderCreated(OrderCreated $event)
    {
        Order::create([
            'id'              => $event->orderUuid,
            'contact_name'    => $event->orderAttributes['contact_name'],
            'contact_address' => $event->orderAttributes['contact_address'],
        ]);
    }
}
