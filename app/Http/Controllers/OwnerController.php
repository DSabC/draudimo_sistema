<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::with('cars')->orderBy('id', 'desc')->get();
        return view('owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::whereNull('owner_id')->orderBy('brand')->get();

        return view('owners.create', compact('cars'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cars' => ['nullable', 'array'],
            'cars.*' => ['integer', 'exists:cars,id'],
        ]);

        DB::transaction(function () use ($data) {
            $owner = Owner::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
            ]);

            if (!empty($data['cars'])) {
                Car::whereIn('id', $data['cars'])->update(['owner_id' => $owner->id]);
            }
        });

        return redirect()->route('owners.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Owner $owner)
    {
        $cars = Car::where(function ($query) use ($owner) {
            $query->whereNull('owner_id')
                ->orWhere('owner_id', $owner->id);
        })->orderBy('brand')->get();
        $selectedCars = $owner->cars->pluck('id')->toArray();

        return view('owners.edit', compact('owner', 'cars', 'selectedCars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cars' => ['nullable', 'array'],
            'cars.*' => ['integer', 'exists:cars,id'],
        ]);

        DB::transaction(function () use ($data, $owner) {
            $owner->update([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
            ]);

            Car::where('owner_id', $owner->id)->update(['owner_id' => null]);

            if (!empty($data['cars'])) {
                Car::whereIn('id', $data['cars'])->update(['owner_id' => $owner->id]);
            }
        });

        return redirect()->route('owners.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index');
    }
}
