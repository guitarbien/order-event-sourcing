<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class OrderCreated implements ShouldBeStored
{
    /** @var string */
    public $orderUuid;

    /** @var array */
    public $orderAttributes;

    /**
     * OrderCreated constructor.
     * @param array $orderAttributes
     */
    public function __construct(array $orderAttributes)
    {
        $this->orderUuid       = $orderAttributes['uuid'];
        $this->orderAttributes = $orderAttributes;
    }
}
