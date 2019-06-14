<?php

namespace App\Aggregates;

/**
 * Class Buyer
 * @package App\Aggregates
 */
class Buyer
{
    /** @var string */
    public $name;

    /** @var string */
    public $address;

    /** @var string */
    public $mobile;

    /** @var string */
    public $email;

    /**
     * Buyer constructor.
     * @param string $name
     * @param string $address
     * @param string $mobile
     * @param string $email
     */
    private function __construct(string $name, string $address, string $mobile, string $email)
    {
        $this->name    = $name;
        $this->address = $address;
        $this->mobile  = $mobile;
        $this->email   = $email;
    }

    /**
     * @param string $name
     * @param string $address
     * @param string $mobile
     * @param string $email
     * @return Buyer
     */
    public static function create(string $name, string $address, string $mobile, string $email): Buyer
    {
        return new Buyer($name, $address, $mobile, $email);
    }
}
