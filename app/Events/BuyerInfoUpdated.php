<?php

namespace App\Events;

use App\Aggregates\Buyer;
use Spatie\EventProjector\ShouldBeStored;

/**
 * Class BuyerInfoUpdated
 * @package App\Events
 */
class BuyerInfoUpdated implements ShouldBeStored
{
    /** @var Buyer */
    public $buyer;

    /**
     * BuyerInfoUpdated constructor.
     * @param Buyer $buyer
     */
    public function __construct(Buyer $buyer)
    {
        $this->buyer = $buyer;
    }
}
