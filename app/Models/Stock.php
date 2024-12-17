<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Stock",
 *     type="object",
 *     required={"id", "city_id", "address", "lat", "lng"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="Уникальный идентификатор склада"
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
 *         example=1,
 *         description="ID города, к которому относится склад"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         example="ул. Пушкина, д. 10",
 *         description="Адрес склада"
 *     ),
 *     @OA\Property(
 *         property="lat",
 *         type="number",
 *         format="float",
 *         example=55.7558,
 *         description="Широта склада"
 *     ),
 *     @OA\Property(
 *         property="lng",
 *         type="number",
 *         format="float",
 *         example=37.6173,
 *         description="Долгота склада"
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
 *     ),
 *     @OA\Property(
 *         property="distance",
 *         type="number",
 *         format="float",
 *         example=5.2,
 *         description="Расстояние до склада (если применимо)"
 *     )
 * )
 */

class Stock extends Model
{
    protected $fillable = [
        'city_id',
        'address',
        'lat',
        'lng',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
