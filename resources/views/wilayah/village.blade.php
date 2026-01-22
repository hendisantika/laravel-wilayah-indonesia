@extends('layouts.app')

@section('title', $village->name . ' - Wilayah Indonesia')

@section('content')
<div class="mb-6">
    <a href="{{ route('wilayah.district', $village->district->code) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
        ← Kembali ke {{ $village->district->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg p-8">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-gray-800">{{ $village->name }}</h1>
        <p class="text-gray-600 mt-2 capitalize">{{ $village->type }} | Kode: {{ $village->code }}</p>
        <div class="mt-3 text-blue-600">
            <p>{{ $village->district->name }}, {{ $village->district->regency->name }}</p>
            <p>{{ $village->district->regency->province->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($village->population)
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm text-gray-600">Populasi</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($village->population) }}</p>
            </div>
        @endif

        @if($village->area)
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-600">Luas Wilayah</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($village->area, 2) }} km²</p>
            </div>
        @endif

        @if($village->postal_code)
            <div class="bg-purple-50 p-4 rounded">
                <p class="text-sm text-gray-600">Kode Pos</p>
                <p class="text-2xl font-bold text-purple-600">{{ $village->postal_code }}</p>
            </div>
        @endif
    </div>

    @if($village->latitude && $village->longitude)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Koordinat</h3>
            <p class="text-gray-600">
                Latitude: {{ $village->latitude }}, Longitude: {{ $village->longitude }}
            </p>
        </div>
    @endif
</div>
@endsection
