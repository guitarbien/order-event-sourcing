<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

/**
 * Class OrderPrepared
 * @package App\Events
 */
class OrderPrepared implements ShouldBeStored
{
    /** @var string */
    public $preparedAt;

    /**
     * OrderPrepared constructor.
     * @param string $preparedAt
     */
    public function __construct(string $preparedAt)
    {
        $this->preparedAt = $preparedAt;
    }
}
