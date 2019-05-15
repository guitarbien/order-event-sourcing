<?php

namespace App\Aggregates;

use App\Events\OrderArrived;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Exceptions\CouldNotChangeStatus;
use Spatie\EventProjector\AggregateRoot;

/**
 * Class OrderAggregateRoot
 * @package App\Aggregates
 * @method static OrderAggregateRoot retrieve(string $uuid)
 */
final class OrderAggregateRoot extends AggregateRoot
{
    /** @var bool */
    private $picked;

    /** @var bool */
    private $prepared;

    /** @var bool */
    private $delivered;

    /** @var bool */
    private $arrived;

    public function createOrder(string $orderUuid, string $contactName, string $contactAddress, string $contactMobile): OrderAggregateRoot
    {
        $this->recordThat(new OrderCreated($orderUuid, $contactName, $contactAddress, $contactMobile));

        return $this;
    }

    public function pickOrder(string $timestamp): OrderAggregateRoot
    {
        if ($this->picked) {
            throw CouldNotChangeStatus::alreadyPicked();
        }

        $this->recordThat(new OrderPicked($timestamp));

        return $this;
    }

    public function applyOrderPicked(): void
    {
        $this->picked = true;
    }

    public function prepareOrder(string $timestamp): OrderAggregateRoot
    {
        if (!$this->picked) {
            throw CouldNotChangeStatus::notPickedYet();
        }

        if ($this->prepared) {
            throw CouldNotChangeStatus::alreadyPrepared();
        }

        $this->recordThat(new OrderPrepared($timestamp));

        return $this;
    }

    public function applyOrderPrepared(): void
    {
        $this->prepared = true;
    }

    public function deliverOrder(string $timestamp): OrderAggregateRoot
    {
        if (!$this->prepared) {
            throw CouldNotChangeStatus::notPreparedYet();
        }

        if ($this->delivered) {
            throw CouldNotChangeStatus::alreadyDelivered();
        }

        $this->recordThat(new OrderDelivered($timestamp));

        return $this;
    }

    public function applyOrderDelivered(): void
    {
        $this->delivered = true;
    }

    public function arriveOrder(string $timestamp): OrderAggregateRoot
    {
        if (!$this->delivered) {
            throw CouldNotChangeStatus::notDeliveredYet()();
        }

        if ($this->arrived) {
            throw CouldNotChangeStatus::alreadyArrived();
        }

        $this->recordThat(new OrderArrived($timestamp));

        return $this;
    }

    public function applyOrderArrived(): void
    {
        $this->arrived = true;
    }
}
