<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'order_status',   
            'id' => (string) $this->id,
            'attributes' => [
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'order' => [
                    'links' => [
                        'related' => route('orders.show', ['order' => $this->order_id]),
                    ],
                ],
                'status' => [
                    'links' => [
                        'related' => route('statuses.show', ['status' => $this->status_id]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('order_status.show', ['order_status' => $this->id]),
            ],
        ];
    }
}
