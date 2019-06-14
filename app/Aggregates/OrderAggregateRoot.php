<?php

namespace App\Aggregates;

use App\Events\BuyerInfoUpdated;
use App\Events\OrderArrived;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderPicked;
use App\Events\OrderPrepared;
use App\Events\ProductAdded;
use App\Exceptions\CouldNotChangeStatus;
use App\Projectors\OrderProjector;
use App\Reactors\OrderCreatedReactor;
use Spatie\EventProjector\AggregateRoot;

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

    /** @var bool */
    private $picked;

    /** @var bool */
    private $prepared;

    /** @var bool */
    private $delivered;

    /** @var bool */
    private $arrived;
    //
    // /**
    //  * @param Product $product
    //  * @return OrderAggregateRoot
    //  * @uses OrderAggregateRoot::applyProductAdded()
    //  */
    // private function addProduct(Product $product): OrderAggregateRoot
    // {
    //     $this->recordThat(new ProductAdded($product));
    //
    //     return $this;
    // }

    /**
     * @param ProductAdded $event
     */
    public function applyProductAdded(ProductAdded $event): void
    {
        $this->orderItems[] = $event->product;
    }
    //
    // /**
    //  * @param Buyer $buyer
    //  * @return OrderAggregateRoot
    //  * @uses OrderAggregateRoot::applyBuyerInfoUpdated()
    //  */
    // private function updateBuyerInfo(Buyer $buyer): OrderAggregateRoot
    // {
    //     $this->recordThat(new BuyerInfoUpdated($buyer));
    //
    //     return $this;
    // }

    /**
     * @param BuyerInfoUpdated $event
     */
    public function applyBuyerInfoUpdated(BuyerInfoUpdated $event): void
    {
        $this->buyer = $event->buyer;
    }

    /**
     * @param Buyer $buyer
     * @param Product ...$products
     * @return OrderAggregateRoot
     * @uses OrderAggregateRoot::applyOrderCreated()
     * @uses OrderAggregateRoot::applyBuyerInfoUpdated()
     * @uses OrderAggregateRoot::applyProductAdded()
     * @uses OrderProjector::onOrderCreated()
     * @uses OrderCreatedReactor::onOrderCreated()
     */
    public function createOrder(Buyer $buyer, Product ...$products): OrderAggregateRoot
    {
        collect($products)->each(function (Product $product) {
            $this->subtotal += $product->getMoney();
            // $this->addProduct($product);
            $this->recordThat(new ProductAdded($product));
        });

        // $this->updateBuyerInfo($buyer)
        $this->recordThat(new BuyerInfoUpdated($buyer))
             ->recordThat(new OrderCreated($this->subtotal, $this->buyer, $this->orderItems));

        return $this;
    }

    /**
     * @param OrderCreated $event
     */
    public function applyOrderCreated(OrderCreated $event): void
    {
        $this->subtotal = $event->subtotal;
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
