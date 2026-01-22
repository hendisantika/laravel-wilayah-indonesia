<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IslandResource;
use App\Models\Island;
use Illuminate\Http\Request;

class IslandController extends Controller
{
    public function index(Request $request)
    {
        $query = Island::query();

        if ($request->has('regency_code')) {
            $query->where('regency_code', $request->regency_code);
        }

        if ($request->has('is_outermost')) {
            $query->where('is_outermost', $request->is_outermost);
        }

        if ($request->has('is_populated')) {
            $query->where('is_populated', $request->is_populated);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('with_regency')) {
            $query->with('regency');
        }

        $islands = $query->get();

        return IslandResource::collection($islands);
    }

    public function show(string $code, Request $request)
    {
        $query = Island::where('code', $code);

        if ($request->has('with_regency')) {
            $query->with('regency');
        }

        $island = $query->firstOrFail();

        return new IslandResource($island);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:9|unique:islands,code',
            'regency_code' => 'nullable|string|size:4|exists:regencies,code',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'is_outermost' => 'required|in:ya,tidak',
            'is_populated' => 'required|in:ya,tidak',
        ]);

        $island = Island::create($validated);

        return new IslandResource($island);
    }

    public function update(Request $request, string $code)
    {
        $island = Island::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'regency_code' => 'nullable|string|size:4|exists:regencies,code',
            'name' => 'sometimes|required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'is_outermost' => 'sometimes|required|in:ya,tidak',
            'is_populated' => 'sometimes|required|in:ya,tidak',
        ]);

        $island->update($validated);

        return new IslandResource($island);
    }

    public function destroy(string $code)
    {
        $island = Island::where('code', $code)->firstOrFail();
        $island->delete();

        return response()->json(['message' => 'Island deleted successfully'], 200);
    }
}
