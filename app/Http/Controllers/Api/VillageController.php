<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VillageResource;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        $query = Village::query();

        if ($request->has('district_code')) {
            $query->where('district_code', $request->district_code);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('with_district')) {
            $query->with('district');
        }

        $villages = $query->get();

        return VillageResource::collection($villages);
    }

    public function show(string $code, Request $request)
    {
        $query = Village::where('code', $code);

        if ($request->has('with_district')) {
            $query->with('district');
        }

        $village = $query->firstOrFail();

        return new VillageResource($village);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:10|unique:villages,code',
            'district_code' => 'required|string|size:6|exists:districts,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:desa,kelurahan',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $village = Village::create($validated);

        return new VillageResource($village);
    }

    public function update(Request $request, string $code)
    {
        $village = Village::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'district_code' => 'sometimes|required|string|size:6|exists:districts,code',
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:desa,kelurahan',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $village->update($validated);

        return new VillageResource($village);
    }

    public function destroy(string $code)
    {
        $village = Village::where('code', $code)->firstOrFail();
        $village->delete();

        return response()->json(['message' => 'Village deleted successfully'], 200);
    }
}
