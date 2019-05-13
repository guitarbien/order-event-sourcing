<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    public function index(): JsonResource
    {
        return new CustomResource(['status' => 'ok']);
    }

    public function store(Request $request)
    {
        Order::createWithAttributes($request->all());

        return new CustomResource(['status' => 'ok']);
    }
}
