<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="City",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Москва",
 *         description="Название города"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-12-17T12:34:56Z",
 *         description="Дата и время создания записи"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-12-18T12:34:56Z",
 *         description="Дата и время последнего обновления записи"
 *     )
 * )
 */

class City extends Model
{
    protected $fillable = [
        'name',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
