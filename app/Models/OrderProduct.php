<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrderProduct',
    title: 'OrderProduct',
    type: 'object',
    required: ['quantity', 'order_id', 'product_id',]
)]
class OrderProduct extends Pivot
{
    use HasFactory;

    #[OA\Property(description: 'Количество', type: 'integer')]
    protected int $quantity;

    #[OA\Property(description: 'Информация о заказе', type: 'string', format: 'json')]
    protected string $properties;

    #[OA\Property(description: 'ID заказа', type: 'integer')]
    protected int $order_id;

    #[OA\Property(description: 'ID продукта', type: 'integer')]
    protected int $product_id;

    protected $fillable = [
        'quantity',
        'properties',
        'order_id',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
