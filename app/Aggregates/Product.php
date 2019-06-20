<?php

namespace App\Aggregates;

/**
 * Class Product
 * @package App\Aggregates
 */
class Product
{
    /** @var int */
    private $prodOid;

    /** @var string */
    private $name;

    /** @var Price */
    private $unitPrice;

    /**
     * Product constructor.
     * @param int $prodOid
     * @param string $name
     * @param Price $unitPrice
     */
    private function __construct(int $prodOid, string $name, Price $unitPrice)
    {
        $this->prodOid   = $prodOid;
        $this->name      = $name;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @param int $prodOid
     * @param string $name
     * @param Price $unitPrice
     * @return Product
     */
    public static function create(int $prodOid, string $name, Price $unitPrice): Product
    {
        return new Product($prodOid, $name, $unitPrice);
    }

    /**
     * @return int
     */
    public function getProdOid(): int
    {
        return $this->prodOid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Price
     */
    public function getUnitPrice(): Price
    {
        return $this->unitPrice;
    }
}
