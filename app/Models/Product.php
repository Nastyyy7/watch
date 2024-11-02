<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;

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
