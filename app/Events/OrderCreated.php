<?php

namespace App\Events;

use App\Aggregates\Buyer;
use App\Aggregates\Product;
use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderCreated
 * @package App\Events
 */
class OrderCreated implements ShouldBeStored
{
    /** @var int */
    public $subtotal;

    /** @var Product[] */
    public $products;

    /** @var Buyer */
    public $buyer;

    /**
     * OrderCreated constructor.
     * @param int $subtotal
     * @param Buyer $buyer
     * @param Product ...$products
     */
    public function __construct(int $subtotal, Buyer $buyer, array $products)
    {
        $this->subtotal = $subtotal;
        $this->products = $products;
        $this->buyer    = $buyer;
    }
}
