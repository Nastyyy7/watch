<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Type',
    title: 'Type',
    type: 'object',
    required: ['name'],
)]
class Type extends Model
{
    #[OA\Property(description: 'Название типа', type: 'string')]
    protected string $name;

    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);

    }
}
