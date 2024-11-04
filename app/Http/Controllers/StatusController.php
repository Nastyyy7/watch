<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Resources\StatusCollection;
use App\Http\Resources\StatusResource;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'status', description: 'Первичный ключ', in: 'path')]
class StatusController extends Controller
{
    #[OA\Get(
        tags: ['Status'],
        description: 'Возвращает перечень статусов',
        path: '/api/v1/statuses/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень статусов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Статус не найден',
        response: 404,
    )]
    public function index()
    {
        $statuses = Status::all();
        return new StatusCollection($statuses);
    }

    #[OA\Post(
        tags: ['Status'],
        description: 'Создаёт статус',
        path: '/api/v1/statuses/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Type'),
            ),
            required: true,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Статус создан',
        response: 201,
    )]
    public function store(StoreStatusRequest $request)
    {
        $data = $request->validated();
        $status = Status::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('statuses.show', [
                'status' => $status->id,
            ]),
        ]);
    }

    #[OA\Get(
        tags: ['Status'],
        description: 'Возвращает статус по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/status'),
        ],
        path: '/api/v1/statuses/{status}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Статус',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Статус не найден',
        response: 404,
    )]
    public function show(Status $status)
    {
        return new StatusResource($status);
    }

    #[OA\Patch(
        tags: ['Status'],
        description: 'Корректирует запись о статусе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/status'),
        ],
        path: '/api/v1/statuses/{status}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Status'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о стастусе откорректирована',
        response: 204,
    )]
    public function update(StoreStatusRequest $request, Status $status)
    {
        $data = $request->validated();
        $status->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['Status'],
        description: 'Удаляет запись о статусе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/status'),
        ],
        path: '/api/v1/statuses/{status}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о статусе удалена',
        response: 204,
    )]
    public function destroy(Status $status)
    {
        $status->delete();
        return response()->noContent(204);
    }
}
