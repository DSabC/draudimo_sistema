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
    public function __construct()
    {
        $this->authorizeResource(Car::class, 'car');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $carsQuery = Car::with('owner')->orderBy('id', 'desc');

        if (! $user->isAdmin() && ! $user->isReader()) {
            $carsQuery->whereHas('owner', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $cars = $carsQuery->get();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = request()->user();
        $ownersQuery = Owner::orderBy('name');

        if (! $user->isAdmin()) {
            $ownersQuery->where('user_id', $user->id);
        }

        $owners = $ownersQuery->get();

        return view('cars.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        $ownerRule = $request->user()->isAdmin()
            ? ['nullable', 'exists:owners,id']
            : ['required', 'exists:owners,id'];

        $data = $request->validate([
            'reg_number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'owner_id' => $ownerRule,
        ]);

        $this->ensureOwnerIsEditable($data['owner_id'] ?? null, $request->user());

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
        $user = request()->user();
        $ownersQuery = Owner::orderBy('name');

        if (! $user->isAdmin()) {
            $ownersQuery->where('user_id', $user->id);
        }

        $owners = $ownersQuery->get();

        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, Car $car)
    {
        $ownerRule = $request->user()->isAdmin()
            ? ['nullable', 'exists:owners,id']
            : ['required', 'exists:owners,id'];

        $data = $request->validate([
            'reg_number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'owner_id' => $ownerRule,
        ]);

        $this->ensureOwnerIsEditable($data['owner_id'] ?? null, $request->user());

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
        $this->authorize('update', $carPhoto->car);

        Storage::disk('public')->delete($carPhoto->path);
        $carPhoto->delete();

        return redirect()->back();
    }

    private function ensureOwnerIsEditable(?int $ownerId, $user): void
    {
        if ($ownerId === null || $user->isAdmin()) {
            return;
        }

        $isEditable = Owner::whereKey($ownerId)
            ->where('user_id', $user->id)
            ->exists();

        abort_if(! $isEditable, 403);
    }
}
