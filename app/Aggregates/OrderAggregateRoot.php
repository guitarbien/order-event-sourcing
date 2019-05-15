<?php

namespace App\Aggregates;

use App\Events\OrderArrived;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
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

    public function pickOrder(string $timestamp)
    {
        $this->recordThat(new OrderPicked($timestamp));

        return $this;
    }

    public function prepareOrder(string $timestamp)
    {
        $this->recordThat(new OrderPrepared($timestamp));

        return $this;
    }

    public function deliverOrder(string $timestamp)
    {
        $this->recordThat(new OrderDelivered($timestamp));

        return $this;
    }

    public function arriveOrder(string $timestamp)
    {
        $this->recordThat(new OrderArrived($timestamp));

        return $this;
    }
}
