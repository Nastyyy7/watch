<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'reviews',   
            'id' => (string) $this->id,
            'attributes' => [
                'content' => $this->content,
                'rating' => $this->rating,
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'product' => [
                    'links' => [
                        'related' => route('order_product.show', ['order_product' => $this->order_product_id]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('reviews.show', ['review' => $this->id]),
            ],
        ];
    }
}
