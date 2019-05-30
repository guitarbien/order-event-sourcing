<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderDelivered
 * @package App\Events
 */
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
