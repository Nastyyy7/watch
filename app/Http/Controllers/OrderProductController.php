<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use App\Http\Resources\OrderProductCollection;
use App\Http\Resources\OrderProductResource;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderProduct = OrderProduct::all();
        return new OrderProductCollection($orderProduct);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderProductRequest $request)
    {
        $data = $request->validated();
        $orderProduct = OrderProduct::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('order_product.show', [
                'order_product' => $orderProduct->id,
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        return new OrderProductResource($orderProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderProductRequest $request, OrderProduct $orderProduct)
    {
        $data = $request->validated();
        $orderProduct->update($data);
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return response()->noContent(204);
    }
}
