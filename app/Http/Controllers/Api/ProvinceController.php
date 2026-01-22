<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $query = Province::query();

        if ($request->has('with_regencies')) {
            $query->with('regencies');
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $provinces = $query->get();

        return ProvinceResource::collection($provinces);
    }

    public function show(string $code, Request $request)
    {
        $query = Province::where('code', $code);

        if ($request->has('with_regencies')) {
            $query->with('regencies');
        }

        $province = $query->firstOrFail();

        return new ProvinceResource($province);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:2|unique:provinces,code',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'elevation' => 'nullable|numeric',
            'timezone' => 'nullable|string|max:50',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'boundaries' => 'nullable|string',
        ]);

        $province = Province::create($validated);

        return new ProvinceResource($province);
    }

    public function update(Request $request, string $code)
    {
        $province = Province::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'elevation' => 'nullable|numeric',
            'timezone' => 'nullable|string|max:50',
            'area' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'boundaries' => 'nullable|string',
        ]);

        $province->update($validated);

        return new ProvinceResource($province);
    }

    public function destroy(string $code)
    {
        $province = Province::where('code', $code)->firstOrFail();
        $province->delete();

        return response()->json(['message' => 'Province deleted successfully'], 200);
    }
}
