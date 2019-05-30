<?php

namespace App\Aggregates;

use App\Events\OrderArrived;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Exceptions\CouldNotChangeStatus;
use App\Projectors\OrderProjector;
use App\Reactors\OrderDeliveredReactor;
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

    /**
     * @param string $orderUuid
     * @param string $contactName
     * @param string $contactAddress
     * @param string $contactMobile
     * @return OrderAggregateRoot
     * @uses OrderProjector::onOrderCreated()
     */
    public function createOrder(
        string $orderUuid,
        string $contactName,
        string $contactAddress,
        string $contactMobile
    ): OrderAggregateRoot {
        $this->recordThat(new OrderCreated($orderUuid, $contactName, $contactAddress, $contactMobile));

        return $this;
    }

    /**
     * @param string $timestamp
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderPicked()
     * @uses OrderProjector::onOrderPicked()
     */
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

    /**
     * @param string $timestamp
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderPrepared()
     * @uses OrderProjector::onOrderPrepared()
     */
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

    /**
     * @param string $timestamp
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderDelivered()
     * @uses OrderProjector::onOrderDelivered()
     * @uses OrderDeliveredReactor::onOrderDelivered()
     */
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

    /**
     * @param string $timestamp
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderArrived()
     * @uses OrderProjector::onOrderArrived()
     */
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
