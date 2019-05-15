<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class OrderPicked implements ShouldBeStored
{
    /** @var string */
    public $pickedAt;

    /**
     * OrderPicked constructor.
     * @param string $pickedAt
     */
    public function __construct(string $pickedAt)
    {
        $this->pickedAt = $pickedAt;
    }
}
