<?php

namespace App;

use App\Events\OrderCreated;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Order
 * @property int $id order uuid
 * @property string $contact_name 收件人姓名
 * @property string $contact_address 收件人地址
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereContactAddress($value)
 * @method static Builder|Order whereContactName($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    protected $fillable = [
        'id',
        'contact_name',
        'contact_address',
    ];

    public static function createWithAttributes(array $attributes)
    {
        $attributes['uuid'] = (string) Str::uuid();

        event(new OrderCreated($attributes));
    }
}
