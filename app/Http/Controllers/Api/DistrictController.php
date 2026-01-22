<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = District::query();

        if ($request->has('regency_code')) {
            $query->where('regency_code', $request->regency_code);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('with_regency')) {
            $query->with('regency');
        }

        if ($request->has('with_villages')) {
            $query->with('villages');
        }

        $districts = $query->get();

        return DistrictResource::collection($districts);
    }

    public function show(string $code, Request $request)
    {
        $query = District::where('code', $code);

        if ($request->has('with_regency')) {
            $query->with('regency');
        }

        if ($request->has('with_villages')) {
            $query->with('villages');
        }

        $district = $query->firstOrFail();

        return new DistrictResource($district);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6|unique:districts,code',
            'regency_code' => 'required|string|size:4|exists:regencies,code',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
        ]);

        $district = District::create($validated);

        return new DistrictResource($district);
    }

    public function update(Request $request, string $code)
    {
        $district = District::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'regency_code' => 'sometimes|required|string|size:4|exists:regencies,code',
            'name' => 'sometimes|required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
        ]);

        $district->update($validated);

        return new DistrictResource($district);
    }

    public function destroy(string $code)
    {
        $district = District::where('code', $code)->firstOrFail();
        $district->delete();

        return response()->json(['message' => 'District deleted successfully'], 200);
    }
}
