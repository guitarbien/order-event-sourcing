<?php

namespace App\Projectors;

use App\Events\OrderCreated;
use App\Order;
use App\OrderProduct;
use DB;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use Spatie\EventProjector\Projectors\QueuedProjector;
use Throwable;

/**
 * Class OrderProjector
 * @package App\Projectors
 */
final class OrderProjector implements QueuedProjector
{
    use ProjectsEvents;

    /**
     * @param OrderCreated $event
     * @param string $aggregateUuid
     * @throws Throwable
     */
    public function onOrderCreated(OrderCreated $event, string $aggregateUuid)
    {
        $qty = count($event->products);
        $products = collect($event->products)->map(function ($product) use ($aggregateUuid, $qty) {
            return [
                'order_id'   => $aggregateUuid,
                'prod_oid'   => $product['prodOid'],
                'prod_name'  => $product['name'],
                'qty'        => $qty,
                'price_unit' => $product['money'],
                'price_sum'  => $product['money'] * $qty,
                'created_at' => now(),
            ];
        })->all();

        DB::transaction(function () use ($event, $products, $aggregateUuid) {
            Order::create([
                'id'              => $aggregateUuid,
                'contact_name'    => $event->buyer->name,
                'contact_address' => $event->buyer->address,
                'contact_mobile'  => $event->buyer->mobile,
                'contact_email'   => $event->buyer->email,
                'price'           => $event->subtotal,
            ]);

            OrderProduct::insert($products);
        });
    }
}
