<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Order
 * @property string $id order uuid
 * @property string $contact_name 收件人姓名
 * @property string $contact_address 收件人地址
 * @property string $contact_mobile 收件人手機
 * @property string $contact_email 收件人email
 * @property int $price 訂單金額
 * @property bool $picked 已揀貨
 * @property Carbon|null $picked_at 揀貨時間
 * @property bool $prepared 已理貨
 * @property Carbon|null $prepared_at 理貨時間
 * @property bool $delivered 已出貨
 * @property Carbon|null $delivered_at 出貨時間
 * @property bool $arrived 已配達
 * @property Carbon|null $arrived_at 配達時間
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereArrived($value)
 * @method static Builder|Order whereArrivedAt($value)
 * @method static Builder|Order whereContactAddress($value)
 * @method static Builder|Order whereContactEmail($value)
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
 * @method static Builder|Order wherePrice($value)
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

    /**
     * @param string $aggregateUuid
     * @return Order|null
     */
    public static function uuid(string $aggregateUuid): ?Order
    {
        return Order::find($aggregateUuid);
    }

    /**
     * @param string $pickedAt
     */
    public function pickedAt(string $pickedAt)
    {
        $this->picked    = true;
        $this->picked_at = $pickedAt;

        $this->save();
    }

    /**
     * @param string $preparedAt
     */
    public function preparedAt(string $preparedAt)
    {
        $this->prepared    = true;
        $this->prepared_at = $preparedAt;

        $this->save();
    }

    /**
     * @param string $deliveredAt
     */
    public function deliveredAt(string $deliveredAt)
    {
        $this->delivered    = true;
        $this->delivered_at = $deliveredAt;

        $this->save();
    }

    /**
     * @param string $arrivedAt
     */
    public function arrivedAt(string $arrivedAt)
    {
        $this->arrived    = true;
        $this->arrived_at = $arrivedAt;

        $this->save();
    }
}
