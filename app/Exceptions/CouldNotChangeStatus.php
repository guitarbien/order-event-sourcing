<?php

namespace App\Exceptions;

use DomainException;

/**
 * Class CouldNotChangeStatus
 * @package App\Exceptions
 */
class CouldNotChangeStatus extends DomainException
{
    /**
     * @return CouldNotChangeStatus
     */
    public static function alreadyPicked(): self
    {
        return new static('could not set picked to true because it\'s true already');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function notPickedYet()
    {
        return new static('could not set prepared to true because it\'s not picked yet');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function alreadyPrepared()
    {
        return new static('could not set prepared to true because it\'s true already');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function notPreparedYet()
    {
        return new static('could not set delivered to true because it\'s not prepared yet');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function alreadyDelivered()
    {
        return new static('could not set delivered to true because it\'s true already');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function notDeliveredYet()
    {
        return new static('could not set arrived to true because it\'s not delivered yet');
    }

    /**
     * @return CouldNotChangeStatus
     */
    public static function alreadyArrived()
    {
        return new static('could not set arrived to true because it\'s true already');
    }
}
