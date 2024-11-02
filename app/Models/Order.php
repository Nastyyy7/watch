<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'pickup_code',
        'user_id',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(OrderProduct::class);
    }

    public function statuses() : BelongsToMany
    {
        return $this->belongsToMany(Status::class)->withTimestamps();

    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);

    }

}
