<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class OrderArrived implements ShouldBeStored
{
    /** @var string */
    public $arrivedAt;

    /**
     * OrderArrived constructor.
     * @param string $arrivedAt
     */
    public function __construct(string $arrivedAt)
    {
        $this->arrivedAt = $arrivedAt;
    }
}
