<?php

namespace App\Aggregates;

use App\Events\BuyerInfoUpdated;
use App\Events\OrderArrived;
use App\Events\OrderCreatedV2;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Events\ProductAdded;
use App\Exceptions\CouldNotChangeStatus;
use App\Projectors\OrderProjector;
use App\Reactors\OrderCreatedReactor;
use Spatie\EventProjector\AggregateRoot;
use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderAggregateRoot
 * @package App\Aggregates
 * @method static OrderAggregateRoot retrieve(string $uuid)
 */
final class OrderAggregateRoot extends AggregateRoot
{
    /** @var Product[] */
    private $orderItems = [];

    /** @var Buyer */
    private $buyer;

    /** @var int */
    private $subtotal = 0;

    /** @var Currency */
    private $currency;

    /** @var bool */
    private $picked;

    /** @var bool */
    private $prepared;

    /** @var bool */
    private $delivered;

    /** @var bool */
    private $arrived;

    /**
     * @param ProductAdded $event
     */
    public function applyProductAdded(ProductAdded $event): void
    {
        $this->orderItems[] = $event->product;
    }

    /**
     * @param BuyerInfoUpdated $event
     */
    public function applyBuyerInfoUpdated(BuyerInfoUpdated $event): void
    {
        $this->buyer = $event->buyer;
    }

    /**
     * @param Buyer $buyer
     * @param string $requestIp
     * @param Product ...$products
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderCreatedV2()
     * @uses OrderAggregateRoot::applyBuyerInfoUpdated()
     * @uses OrderAggregateRoot::applyProductAdded()
     * @uses OrderProjector::onOrderCreated()
     * @uses OrderCreatedReactor::onOrderCreated()
     */
    public function createOrder(Buyer $buyer, string $requestIp, Product ...$products): OrderAggregateRoot
    {
        collect($products)->each(function (Product $product) {
            $this->subtotal += $product->getUnitPrice()->getAmount();
            $this->recordThat(new ProductAdded($product));
        });

        $this->currency = $products[0]->getUnitPrice()->getCurrency();

        $this->recordThat(new BuyerInfoUpdated($buyer))
             ->recordThat(
                 new OrderCreatedV2(
                     Price::create($products[0]->getUnitPrice()->getCurrency(), $this->subtotal),
                     $this->orderItems,
                     $this->buyer,
                     $requestIp
                 )
             );

        return $this;
    }

    /**
     * @param OrderCreatedV2 $event
     */
    public function applyOrderCreatedV2(OrderCreatedV2 $event): void
    {
        $this->subtotal = $event->subtotal->getAmount();
        $this->currency = $event->subtotal->getCurrency();
    }

    /**
     * @param string $timestamp
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderPicked()
     * @uses OrderProcessProjector::onOrderPicked()
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
     * @uses OrderProcessProjector::onOrderPrepared()
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
     * @uses OrderProcessProjector::onOrderDelivered()
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
     * @uses OrderProcessProjector::onOrderArrived()
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
