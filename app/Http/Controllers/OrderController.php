<?php

namespace App\Http\Controllers;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Resources\CustomResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /** @var array */
    private const ACTION_MAPPING = [
        'picked'    => 'pickOrder',
        'prepared'  => 'prepareOrder',
        'delivered' => 'deliverOrder',
        'arrived'   => 'arriveOrder',
    ];

    public function index(): JsonResource
    {
        return new CustomResource(['status' => 'ok']);
    }

    public function store(Request $request)
    {
        $orderUuid = (string) Str::uuid();

        OrderAggregateRoot::retrieve($orderUuid)
                          ->createOrder(
                              $orderUuid,
                              $request->get('contact_name'),
                              $request->get('contact_address'),
                              $request->get('contact_mobile')
                          )
                          ->persist();

        return new CustomResource([
            'status'    => 'ok',
            'orderUuid' => $orderUuid,
        ]);
    }

    public function update(Order $order, Request $request)
    {
        $action = $request->get('action');

        $actionMethod = self::ACTION_MAPPING[$action];

        OrderAggregateRoot::retrieve($order->id)
                          ->{$actionMethod}($request->get('timestamp'))
                          ->persist();

        return new CustomResource(['status' => 'ok']);
    }
}
