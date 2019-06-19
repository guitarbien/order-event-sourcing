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
        $products = collect($event->products)
            ->groupBy('prodOid')
            ->map(function ($productGroup) use ($aggregateUuid) {
                $qty = count($productGroup);

                return [
                    'order_id'   => $aggregateUuid,
                    'prod_oid'   => $productGroup[0]['prodOid'],
                    'prod_name'  => $productGroup[0]['name'],
                    'qty'        => $qty,
                    'price_unit' => $productGroup[0]['money'],
                    'price_sum'  => $productGroup[0]['money'] * $qty,
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
