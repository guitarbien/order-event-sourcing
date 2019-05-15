<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class OrderDelivered implements ShouldBeStored
{
    /** @var string */
    public $deliveredAt;

    /**
     * OrderDelivered constructor.
     * @param string $deliveredAt
     */
    public function __construct(string $deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;
    }
}
