<?php

namespace App\Http\Controllers;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Requests\NewOrderRequest;
use App\Http\Resources\CustomResource;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /** @var array */
    private const ACTION_MAPPING = [
        'picked'    => 'pickOrder',
        'prepared'  => 'prepareOrder',
        'delivered' => 'deliverOrder',
        'arrived'   => 'arriveOrder',
    ];

    /**
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return new CustomResource(['status' => 'ok']);
    }

    /**
     * @param NewOrderRequest $request
     * @return JsonResponse
     * @uses OrderAggregateRoot::createOrder()
     */
    public function store(NewOrderRequest $request): JsonResponse
    {
        $uuid = (string) Str::uuid();

        $orderAggregateRoot = OrderAggregateRoot::retrieve($uuid);

        $orderAggregateRoot->createOrder($request->getBuyer(), ...$request->getProducts())
                           ->persist();

        return (new CustomResource([
            'status'    => 'ok',
            'orderUuid' => $uuid,
        ]))->response()->setStatusCode(201);
    }

    /**
     * @uses OrderAggregateRoot::pickOrder()
     * @uses OrderAggregateRoot::prepareOrder()
     * @uses OrderAggregateRoot::deliverOrder()
     * @uses OrderAggregateRoot::arriveOrder()
     * @param Order $order
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Order $order, Request $request): JsonResponse
    {
        $action = $request->get('action');

        $actionMethod = self::ACTION_MAPPING[$action];

        OrderAggregateRoot::retrieve($order->id)
                          ->{$actionMethod}($request->get('timestamp'))
                          ->persist();

        return (new CustomResource(['status' => 'ok']))
            ->response()
            ->setStatusCode(200);
    }
}
