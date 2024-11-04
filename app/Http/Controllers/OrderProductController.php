<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use App\Http\Resources\OrderProductCollection;
use App\Http\Resources\OrderProductResource;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'order_product', description: 'Первичный ключ', in: 'path')]
class OrderProductController extends Controller
{
    #[OA\Get(
        tags: ['OrderProduct'],
        description: 'Возвращает перечень закзанных продуктов',
        path: '/api/v1/order_product/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень закзанных продуктов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Закзанный продукт не найден',
        response: 404,
    )]
    public function index()
    {
        $orderProduct = OrderProduct::all();
        return new OrderProductCollection($orderProduct);
    }

    #[OA\Post(
        tags: ['OrderProduct'],
        description: 'Создаёт закзанный продукт',
        path: '/api/v1/order_product/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/OrderProduct'),
            ),
            required: true,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Закзанный продукт создан',
        response: 201,
    )]
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

    #[OA\Get(
        tags: ['OrderProduct'],
        description: 'Возвращает закзанный продукт по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order_product'),
        ],
        path: '/api/v1/order_product/{order_product}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Закзанный продукт',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Закзанный продукт не найден',
        response: 404,
    )]
    public function show(OrderProduct $orderProduct)
    {
        return new OrderProductResource($orderProduct);
    }

    #[OA\Patch(
        tags: ['OrderProduct'],
        description: 'Корректирует запись о заказанном продукте',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order_product'),
        ],
        path: '/api/v1/order_product/{order_product}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/OrderProduct'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о заказанном продукте откорректирована',
        response: 204,
    )]
    public function update(StoreOrderProductRequest $request, OrderProduct $orderProduct)
    {
        $data = $request->validated();
        $orderProduct->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['OrderProduct'],
        description: 'Удаляет запись о заказанном продукте',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/order_product'),
        ],
        path: '/api/v1/order_product/{order_product}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о заказанном продукте удалена',
        response: 204,
    )]
    public function destroy(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return response()->noContent(204);
    }
}
