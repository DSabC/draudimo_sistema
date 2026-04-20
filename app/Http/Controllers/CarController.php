<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\CarPhoto;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with('owner')->orderBy('id', 'desc')->get();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = Owner::orderBy('name')->get();
        return view('cars.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        $data = $request->validate([
            'reg_number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'owner_id' => ['nullable', 'exists:owners,id'],
        ]);

        Car::create($data);

        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car->load('photos');
        $owners = Owner::orderBy('name')->get();
        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, Car $car)
    {
        $data = $request->validate([
            'reg_number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'owner_id' => ['nullable', 'exists:owners,id'],
        ]);

        $car->update($data);

        if(request()->hasFile('photos')) {
            foreach(request()->file('photos') as $photo) {
                $path = $photo->store('cars', 'public');

                $car->photos()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('cars.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }

    public function destroyPhoto(CarPhoto $carPhoto)
    {
        Storage::disk('public')->delete($carPhoto->path);
        $carPhoto->delete();

        return redirect()->back();
    }
}
