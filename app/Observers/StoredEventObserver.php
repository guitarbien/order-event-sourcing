<?php

namespace App\Observers;

use \Spatie\EventProjector\Models\StoredEvent;

/**
 * Class StoredEventObserver
 * @package App\Observers
 */
class StoredEventObserver
{
    /** @var int */
    private static $currentVersion;

    /**
     * @param StoredEvent $storedEvent
     */
    public function retrieved(StoredEvent $storedEvent): void
    {
        self::$currentVersion = $storedEvent->version;
    }

    /**
     * Handle the stored event "creating" event.
     * @param StoredEvent $storedEvent
     * @return void
     */
    public function creating(StoredEvent $storedEvent): void
    {
        self::$currentVersion++;
        $storedEvent->version = self::$currentVersion;
    }
}
