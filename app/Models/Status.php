<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Status',
    title: 'Status',
    type: 'object',
    required: ['name'],
)]
class Status extends Model
{
    #[OA\Property(description: 'Название статуса', type: 'string')]
    protected string $name;

    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function orders() : BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withTimestamps();

    }
}

