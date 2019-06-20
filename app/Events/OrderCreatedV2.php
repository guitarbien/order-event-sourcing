<?php

namespace App\Events;

use App\Aggregates\Buyer;
use App\Aggregates\Price;
use App\Aggregates\Product;
use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderCreatedV2
 * @package App\Events
 */
class OrderCreatedV2 implements ShouldBeStored
{
    /** @var Price */
    public $subtotal;

    /** @var string */
    public $requestIp;

    /** @var Product[] */
    public $products;

    /** @var Buyer */
    public $buyer;

    /**
     * OrderCreatedV2 constructor.
     * @param Price $subtotal
     * @param array $products
     * @param Buyer $buyer
     * @param string $requestIp
     */
    public function __construct(Price $subtotal, array $products, Buyer $buyer, string $requestIp = '')
    {
        $this->subtotal  = $subtotal;
        $this->requestIp = $requestIp;
        $this->products  = $products;
        $this->buyer     = $buyer;
    }
}
