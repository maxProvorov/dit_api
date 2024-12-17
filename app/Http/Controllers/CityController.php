<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @OA\Info(
     *     title="City and Stock API",
     *     version="1.0",
     *     description="API для работы с городами и складами."
     * )
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     */
    public function index()
    {
        return response()->json(City::all());
    }

    /**
     * @OA\Get(
     *     path="/api/city/{id}",
     *     summary="Получить информацию о городе",
     *     tags={"Cities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID города",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о городе",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(response=404, description="Город не найден")
     * )
     */

    public function show($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    /**
     * @OA\Post(
     *     path="/api/city",
     *     summary="Добавить новый город",
     *     tags={"Cities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Город создан",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = City::create([
            'name' => $request->name,
        ]);

        return response()->json($city, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/city/{id}",
     *     summary="Обновить информацию о городе",
     *     tags={"Cities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID города",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Город обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city->update([
            'name' => $request->name,
        ]);

        return response()->json($city);
    }

    /**
     * @OA\Delete(
     *     path="/api/city/{id}",
     *     summary="Удалить город",
     *     tags={"Cities"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID города",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Город удален"),
     *     @OA\Response(response=404, description="Город не найден")
     * )
     */
    
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(null, 204);
    }
}
