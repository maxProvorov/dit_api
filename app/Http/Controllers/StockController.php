<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\City;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/stocks",
     *     summary="Получить список всех складов",
     *     tags={"Stocks"},
     *     @OA\Response(
     *         response=200,
     *         description="Список складов",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Stock"))
     *     )
     * )
     */

    public function index()
    {
        return response()->json(Stock::all());
    }

    /**
     * @OA\Get(
     *     path="/api/stocks/{id}",
     *     summary="Получить информацию о складе",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о складе",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     )
     * )
     */

    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock);
    }

    /**
     * @OA\Post(
     *     path="/api/stocks",
     *     summary="Добавить новый склад",
     *     tags={"Stocks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Склад создан",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации данных"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $stock = Stock::create([
            'city_id' => $request->city_id,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json($stock, 201);
    }

    /**
     * @OA\Put(
     *     path="/stock/{id}",
     *     summary="Обновить склад",
     *     tags={"Stocks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада для обновления",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city_id", "address", "lat", "lng"},
     *             @OA\Property(property="city_id", type="integer", example=1, description="ID города"),
     *             @OA\Property(property="address", type="string", example="ул. Ленина, д. 10", description="Адрес склада"),
     *             @OA\Property(property="lat", type="number", format="float", example=55.7558, description="Широта склада"),
     *             @OA\Property(property="lng", type="number", format="float", example=37.6173, description="Долгота склада")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное обновление склада",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Склад не найден"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации данных"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $stock->update([
            'city_id' => $request->city_id,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json($stock);
    }

    /**
     * @OA\Delete(
     *     path="/stock/{id}",
     *     summary="Удалить склад",
     *     tags={"Stocks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада для удаления",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Склад успешно удален"
     *     ),
     * )
     */

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/city/{cityId}/stocks",
     *     summary="Получить список складов в городе",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="cityId",
     *         in="path",
     *         required=true,
     *         description="ID города",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список складов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Stock")
     *         )
     *     ),
     * )
     */

    public function stocksByCity($cityId)
    {
        $city = City::findOrFail($cityId);
        return response()->json($city->stocks);
    }

    /**
     * @OA\Post(
     *     path="/api/stock/nearby",
     *     summary="Поиск ближайшего склада",
     *     tags={"Stocks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="lat", type="number", example=23.323232),
     *             @OA\Property(property="lng", type="number", example=23.212143)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ближайший склад",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     )
     * )
     */

    public function nearestStock(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $latitude = $request->lat;
        $longitude = $request->lng;

        $stocks = Stock::all();

        $nearestStock = $stocks->map(function ($stock) use ($latitude, $longitude) {
            $distance = $this->haversineDistance($latitude, $longitude, $stock->lat, $stock->lng);
            $stock->distance = $distance;
            return $stock;
        })
        ->sortBy('distance')
        ->first();

        if ($nearestStock) {
            $city = City::find($nearestStock->city_id);
            $nearestStock->city = $city;
            return response()->json($nearestStock);
        }

        return response()->json(['message' => 'Склад не найден'], 404);
    }


    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1) . ' km';
    }
}
