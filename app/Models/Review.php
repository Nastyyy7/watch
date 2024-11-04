<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Review',
    title: 'Review',
    type: 'object',
    required: ['content', 'rating', 'order_product_id',]
)]
class Review extends Model
{
    #[OA\Property(description: 'Текст отзыва', type: 'string')]
    protected string $content;

    #[OA\Property(description: 'Оценка', type: 'integer')]
    protected int $rating;

    #[OA\Property(description: 'ID заказанного продукта', type: 'integer')]
    protected int $order_product_id;

    use HasFactory;

    protected $fillable = [
        'content',
        'rating',
        'order_product_id',
    ];

    public function products() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProduct() : BelongsTo
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
