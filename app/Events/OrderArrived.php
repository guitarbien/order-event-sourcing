<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderArrived
 * @package App\Events
 */
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
