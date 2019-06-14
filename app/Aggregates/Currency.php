<?php

namespace App\Aggregates;

use MyCLabs\Enum\Enum;

/**
 * Class Currency
 * @package App\Aggregates
 * @method static Currency TWD()
 * @method static Currency USD()
 * @method static Currency JPY()
 */
class Currency extends Enum
{
    private const TWD = 'TWD';
    private const USD = 'USD';
    private const JPY = 'JPY';
}
