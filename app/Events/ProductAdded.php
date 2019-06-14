<?php

namespace App\Events;

use App\Aggregates\Product;
use Spatie\EventProjector\ShouldBeStored;

/**
 * Class ProductAdded
 * @package App\Events
 */
class ProductAdded implements ShouldBeStored
{
    /** @var Product */
    public $product;

    /**
     * ProductAdded constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
