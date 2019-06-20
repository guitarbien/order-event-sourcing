<?php

namespace App\Projectors;

use App\Aggregates\Currency;
use App\Aggregates\Price;
use App\Events\OrderCreated;
use App\Events\OrderCreatedV2;
use App\Order;
use App\OrderProduct;
use DB;
use Spatie\EventProjector\Projectors\ProjectsEvents;
use Spatie\EventProjector\Projectors\QueuedProjector;

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
     */
    public function onOrderCreated(OrderCreated $event, string $aggregateUuid)
    {
        $this->onOrderCreatedV2(
            new OrderCreatedV2(
                Price::create(Currency::TWD(), $event->subtotal),
                $event->products,
                $event->buyer
            ),
            $aggregateUuid
        );
    }

    /**
     * @param OrderCreatedV2 $event
     * @param string $aggregateUuid
     */
    public function onOrderCreatedV2(OrderCreatedV2 $event, string $aggregateUuid)
    {
        $products = collect($event->products)
            ->groupBy('prodOid')
            ->map(function ($productGroup) use ($aggregateUuid) {
                $qty   = count($productGroup);
                $money = $productGroup[0]['unitPrice']['amount'];

                return [
                    'order_id'   => $aggregateUuid,
                    'prod_oid'   => $productGroup[0]['prodOid'],
                    'prod_name'  => $productGroup[0]['name'],
                    'qty'        => $qty,
                    'price_unit' => $money,
                    'price_sum'  => $money * $qty,
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
                'price'           => $event->subtotal->getAmount(),
            ]);

            OrderProduct::insert($products);
        });
    }
}
