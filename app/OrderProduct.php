<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\OrderProduct
 * @property int $id
 * @property string $order_id
 * @property int $prod_oid
 * @property string $prod_name
 * @property int $qty
 * @property int $price_unit
 * @property int $price_sum
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct wherePriceSum($value)
 * @method static Builder|OrderProduct wherePriceUnit($value)
 * @method static Builder|OrderProduct whereProdName($value)
 * @method static Builder|OrderProduct whereProdOid($value)
 * @method static Builder|OrderProduct whereQty($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderProduct extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
