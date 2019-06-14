<?php

namespace App\Aggregates;

/**
 * Class Price
 * @package App\Aggregates
 */
class Price
{
    /** @var Currency */
    private $currency;

    /** @var int */
    private $amount;

    /**
     * Price constructor.
     * @param Currency $currency
     * @param int $amount
     */
    private function __construct(Currency $currency, int $amount)
    {
        $this->currency = $currency;
        $this->amount   = $amount;
    }

    /**
     * @param Currency $currency
     * @param int $amount
     * @return Price
     */
    public static function create(Currency $currency, int $amount): Price
    {
        return new Price($currency, $amount);
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
