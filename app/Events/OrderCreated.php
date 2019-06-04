<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderCreated
 * @package App\Events
 */
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

    /** @var string */
    public $contactEmail;

    /** @var array */
    public $products;

    /**
     * OrderCreated constructor.
     * @param string $orderUuid
     * @param string $contactName
     * @param string $contactAddress
     * @param string $contactMobile
     * @param string $contactEmail
     * @param array $products
     */
    public function __construct(
        string $orderUuid,
        string $contactName,
        string $contactAddress,
        string $contactMobile,
        string $contactEmail,
        array $products
    ) {
        $this->orderUuid      = $orderUuid;
        $this->contactName    = $contactName;
        $this->contactAddress = $contactAddress;
        $this->contactMobile  = $contactMobile;
        $this->contactEmail   = $contactEmail;
        $this->products       = $products;
    }
}
