<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'order_product',
            'id' => (string) $this->id,
            'attributes' => [
                'quantity' => (int) $this->quantity,
                'properties' => $this->properties,
            ],
            'relationships' => [
                'order' => [
                    'links' => [
                        'related' => route('orders.show', ['order' => $this->order_id]),
                    ],
                ],
                'product' => [
                    'links' => [
                        'related' => route('products.show', ['product' => $this->product_id]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('order_product.show', ['order_product' => $this->id]),
            ],
        ];
    }
}
