<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
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
