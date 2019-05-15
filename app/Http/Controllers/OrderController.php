<?php

namespace App\Http\Controllers;

use App\Aggregates\OrderAggregateRoot;
use App\Http\Resources\CustomResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class OrderController extends Controller
{
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
}
