<?php

namespace App\Aggregates;

use App\Events\OrderCreated;
use Spatie\EventProjector\AggregateRoot;

/**
 * Class OrderAggregateRoot
 * @package App\Aggregates
 * @method static OrderAggregateRoot retrieve(string $uuid)
 */
final class OrderAggregateRoot extends AggregateRoot
{
    public function createOrder(string $orderUuid, string $contactName, string $contactAddress, string $contactMobile)
    {
        $this->recordThat(new OrderCreated($orderUuid, $contactName, $contactAddress, $contactMobile));

        return $this;
    }
}
