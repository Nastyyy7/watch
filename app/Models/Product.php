<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    title: 'Product',
    type: 'object',
    required: ['name', 'photo', 'price', 'quantity', 'type_id'],
)]
class Product extends Model
{
    use HasFactory;

    #[OA\Property(description: 'Название продукта', type: 'string')]
    protected string $name;

    #[OA\Property(description: 'Цена продукта', type: 'integer', format: 'float')]
    protected float $price;

    #[OA\Property(description: 'Описание продукта', type: 'string', format: 'json')]
    protected string $properties;

    #[OA\Property(description: 'Количество на складе', type: 'integer')]
    protected int $quantity;

    #[OA\Property(description: 'Доступность продукта', type: 'boolean')]
    protected bool $available;

    #[OA\Property(description: 'ID типа продукта', type: 'integer')]
    protected int $type_id;
    
    protected $fillable = [
        'name',
        'photo',
        'price',
        'properties',
        'quantity',
        'available',
        'type_id'
    ];

    public function review(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            OrderProduct::class,
            'product_id',
            'order_product_id',
            'id',
            'id'
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->using(OrderProduct::class);
    }
}
