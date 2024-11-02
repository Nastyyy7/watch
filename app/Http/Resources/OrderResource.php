<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'orders',
            'id' => (string) $this->id,
            'attributes' => [
                'total_price' => (float) $this->total_price,
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'user' => [
                    'links' => [
                        'related' => route('users.show', ['user' => $this->user_id]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('orders.show', ['order' => $this->id]),
            ],
        ];
    }
}
