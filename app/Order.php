<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Order
 * @property int $id order uuid
 * @property string $contact_name 收件人姓名
 * @property string $contact_address 收件人地址
 * @property string $contact_mobile 收件人手機
 * @property bool $picked 已揀貨
 * @property string|null $picked_at 揀貨時間
 * @property bool $prepared 已理貨
 * @property string|null $prepared_at 理貨時間
 * @property bool $delivered 已出貨
 * @property string|null $delivered_at 出貨時間
 * @property bool $arrived 已配達
 * @property string|null $arrived_at 配達時間
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereArrived($value)
 * @method static Builder|Order whereArrivedAt($value)
 * @method static Builder|Order whereContactAddress($value)
 * @method static Builder|Order whereContactMobile($value)
 * @method static Builder|Order whereContactName($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDelivered($value)
 * @method static Builder|Order whereDeliveredAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order wherePicked($value)
 * @method static Builder|Order wherePickedAt($value)
 * @method static Builder|Order wherePrepared($value)
 * @method static Builder|Order wherePreparedAt($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    protected $dates = [
        'created_at',
        'updated_at',
        'picked_at',
        'prepared_at',
        'delivered_at',
        'arrived_at',
    ];

    public static function uuid(string $aggregateUuid): Order
    {
        return Order::find($aggregateUuid);
    }

    public function pickedAt(string $pickedAt)
    {
        $this->picked    = true;
        $this->picked_at = $pickedAt;

        $this->save();
    }

    public function preparedAt(string $preparedAt)
    {
        $this->prepared    = true;
        $this->prepared_at = $preparedAt;

        $this->save();
    }

    public function deliveredAt(string $deliveredAt)
    {
        $this->delivered    = true;
        $this->delivered_at = $deliveredAt;

        $this->save();
    }

    public function arrivedAt(string $arrivedAt)
    {
        $this->arrived    = true;
        $this->arrived_at = $arrivedAt;

        $this->save();
    }
}
