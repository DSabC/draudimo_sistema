<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarApiController extends Controller
{
    public function index(): JsonResponse
    {
        $cars = Car::with('owner')->orderBy('id')->get();

        return response()->json($cars);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reg_number' => ['required', 'regex:/^[A-Z]{3}[0-9]{3}$/', 'unique:cars,reg_number'],
            'brand' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'owner_id' => ['nullable', 'exists:owners,id'],
        ]);

        $car = Car::create($data);

        return response()->json($car, 201);
    }

    public function show(Car $car): JsonResponse
    {
        $car->load('owner');

        return response()->json($car);
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $data = $request->validate([
            'reg_number' => ['required', 'regex:/^[A-Z]{3}[0-9]{3}$/', 'unique:cars,reg_number,' . $car->id],
            'brand' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'owner_id' => ['nullable', 'exists:owners,id'],
        ]);

        $car->update($data);

        return response()->json($car);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully.',
        ]);
    }
}
