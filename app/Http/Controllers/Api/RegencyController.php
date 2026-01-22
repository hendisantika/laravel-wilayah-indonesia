<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegencyResource;
use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Regency::query();

        if ($request->has('province_code')) {
            $query->where('province_code', $request->province_code);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('with_province')) {
            $query->with('province');
        }

        if ($request->has('with_districts')) {
            $query->with('districts');
        }

        $regencies = $query->get();

        return RegencyResource::collection($regencies);
    }

    public function show(string $code, Request $request)
    {
        $query = Regency::where('code', $code);

        if ($request->has('with_province')) {
            $query->with('province');
        }

        if ($request->has('with_districts')) {
            $query->with('districts');
        }

        if ($request->has('with_islands')) {
            $query->with('islands');
        }

        $regency = $query->firstOrFail();

        return new RegencyResource($regency);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:4|unique:regencies,code',
            'province_code' => 'required|string|size:2|exists:provinces,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:kabupaten,kota',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'elevation' => 'nullable|numeric',
            'timezone' => 'nullable|string|max:50',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'boundaries' => 'nullable|string',
        ]);

        $regency = Regency::create($validated);

        return new RegencyResource($regency);
    }

    public function update(Request $request, string $code)
    {
        $regency = Regency::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'province_code' => 'sometimes|required|string|size:2|exists:provinces,code',
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:kabupaten,kota',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'elevation' => 'nullable|numeric',
            'timezone' => 'nullable|string|max:50',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'boundaries' => 'nullable|string',
        ]);

        $regency->update($validated);

        return new RegencyResource($regency);
    }

    public function destroy(string $code)
    {
        $regency = Regency::where('code', $code)->firstOrFail();
        $regency->delete();

        return response()->json(['message' => 'Regency deleted successfully'], 200);
    }
}
