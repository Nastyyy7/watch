<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderStatusCollection;
use App\Http\Resources\OrderStatusResource;
use App\Models\Order;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderStatus = OrderStatus::all();
        return new OrderStatusCollection($orderStatus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderStatusRequest $request)
    {
        $data = $request->validated();
        $orderStatus = OrderStatus::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('order_status.show', [
                'order_status' => $orderStatus->id,
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus)
    {
        return new OrderStatusResource($orderStatus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusRequest $request, OrderStatus $orderStatus)
    {
        $data = $request->validated();
        $orderStatus->update($data);
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();
        return response()->noContent(204);
    }
}
