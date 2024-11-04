<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'review', description: 'Первичный ключ', in: 'path')]
class ReviewController extends Controller
{
    #[OA\Get(
        tags: ['Review'],
        description: 'Возвращает перечень отзывов',
        path: '/api/v1/reviewes/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень отзывов',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Отзыв не найден',
        response: 404,
    )]
    public function index()
    {
        $reviews = Review::all();
        return new ReviewCollection($reviews);
    }

    #[OA\Post(
        tags: ['Review'],
        description: 'Создаёт отзыв',
        path: '/api/v1/reviewes/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Review'),
            ),
            required: true,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Отзыв создан',
        response: 201,
    )]
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $review = Review::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('reviews.show', [
                'review' => $review->id,
            ]),
        ]);
    }

    #[OA\Get(
        tags: ['Review'],
        description: 'Возвращает отзыв по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/review'),
        ],
        path: '/api/v1/reviewes/{review}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Отзыв',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Отзыв не найден',
        response: 404,
    )]
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    #[OA\Patch(
        tags: ['Review'],
        description: 'Корректирует запись об отзыве',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/review'),
        ],
        path: '/api/v1/reviewes/{review}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Review'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись об отзыве откорректирована',
        response: 204,
    )]
    public function update(StoreReviewRequest $request, Review $review)
    {
        $data = $request->validated();
        $review->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['Review'],
        description: 'Удаляет запись об отзыве',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/review'),
        ],
        path: '/api/v1/reviewes/{review}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись об отзыве удалена',
        response: 204,
    )]
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->noContent(204);
    }
}
