<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class OrderCreated implements ShouldBeStored
{
    /** @var string */
    public $orderUuid;

    /** @var string */
    public $contactName;

    /** @var string */
    public $contactAddress;

    /** @var string */
    public $contactMobile;

    /**
     * OrderCreated constructor.
     * @param string $orderUuid
     * @param string $contactName
     * @param string $contactAddress
     * @param string $contactMobile
     */
    public function __construct(string $orderUuid, string $contactName, string $contactAddress, string $contactMobile)
    {
        $this->orderUuid      = $orderUuid;
        $this->contactName    = $contactName;
        $this->contactAddress = $contactAddress;
        $this->contactMobile  = $contactMobile;
    }
}
