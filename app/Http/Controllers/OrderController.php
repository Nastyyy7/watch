<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'order', description: 'Первичный ключ', in: 'path')]
class OrderController extends Controller
{
    #[OA\Get(
        tags: ['Order'],
        description: 'Возвращает перечень заказов',
        path: '/api/v1/orders/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень заказов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Заказ не найден',
        response: 404,
    )]
    public function index()
    {
        $orders = Order::all();
        return new OrderCollection($orders);
    }

    #[OA\Post(
        tags: ['Order'],
        description: 'Создаёт заказ',
        path: '/api/v1/orders/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Order'),
            ),
            required: true,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Заказ создан',
        response: 201,
    )]
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('orders.show', [
                'orders' => $order->id,
            ]),
        ]);
    }

    #[OA\Get(
        tags: ['Order'],
        description: 'Возвращает заказ по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order'),
        ],
        path: '/api/v1/orders/{order}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Заказ',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Заказ не найден',
        response: 404,
    )]
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    #[OA\Patch(
        tags: ['Order'],
        description: 'Корректирует запись о заказе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order'),
        ],
        path: '/api/v1/orders/{order}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Order'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о заказе откорректирована',
        response: 204,
    )]
    public function update(StoreOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['Order'],
        description: 'Удаляет запись о заказе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order'),
        ],
        path: '/api/v1/orders/{order}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о заказе удалена',
        response: 204,
    )]
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent(204);
    }
}
