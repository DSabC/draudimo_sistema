<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OwnerApiController extends Controller
{
    public function index(): JsonResponse
    {
        $owners = Owner::with('cars')->orderBy('id')->get();

        return response()->json($owners);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $owner = Owner::create($data);

        return response()->json($owner, 201);
    }

    public function show(Owner $owner): JsonResponse
    {
        $owner->load('cars');

        return response()->json($owner);
    }

    public function update(Request $request, Owner $owner): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $owner->update($data);

        return response()->json($owner);
    }

    public function destroy(Owner $owner): JsonResponse
    {
        $owner->delete();

        return response()->json([
            'message' => 'Owner deleted successfully.',
        ]);
    }
}
