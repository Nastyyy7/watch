<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Resources\TypeCollection;
use App\Http\Resources\TypeResource;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'type', description: 'Первичный ключ', in: 'path')]
class TypeController extends Controller
{
    #[OA\Get(
        tags: ['Type'],
        description: 'Возвращает перечень типов',
        path: '/api/v1/types/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень типов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Тип не найден',
        response: 404,
    )]
    public function index()
    {
        $types = Type::all();
        return new TypeCollection($types);
    }

    #[OA\Post(
        tags: ['Type'],
        description: 'Создаёт тип',
        path: '/api/v1/types/',
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
        description: 'Тип создан',
        response: 201,
    )]
    public function store(StoreTypeRequest $request)
    {
        $data = $request->validated();
        $type = Type::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('types.show', [
                'type' => $type->id,
            ]),
        ]);
    }

    #[OA\Get(
        tags: ['Type'],
        description: 'Возвращает тип по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/type'),
        ],
        path: '/api/v1/types/{type}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Тип',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Тип не найден',
        response: 404,
    )]
    public function show(Type $type)
    {
        return new TypeResource($type);
    }

    #[OA\Patch(
        tags: ['Type'],
        description: 'Корректирует запись о типе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/type'),
        ],
        path: '/api/v1/types/{type}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Type'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о типе откорректирована',
        response: 204,
    )]
    public function update(StoreTypeRequest $request, Type $type)
    {
        $data = $request->validated();
        $type->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['Type'],
        description: 'Удаляет запись о типе',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/type'),
        ],
        path: '/api/v1/types/{type}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о типе удалена',
        response: 204,
    )]
    public function destroy(Type $type)
    {
        $type->delete();
        return response()->noContent(204);
    }
}
