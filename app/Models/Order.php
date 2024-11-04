<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Order',
    title: 'Order',
    type: 'object',
    required: ['total_price', 'user_id'],
)]
class Order extends Model
{
    use HasFactory;

    #[OA\Property(description: 'Общая цена', type: 'integer', format: 'float')]
    protected string $total_price;

    #[OA\Property(description: 'ID пользователя', type: 'integer')]
    protected int $user_id;

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
