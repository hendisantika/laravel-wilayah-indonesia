@extends('layouts.app')

@section('title', $province->name . ' - Wilayah Indonesia')

@section('content')
<div class="mb-6">
    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
        ← Kembali ke Daftar Provinsi
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg p-8 mb-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">{{ $province->name }}</h1>
            <p class="text-gray-600 mt-2">Kode: {{ $province->code }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @if($province->population)
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm text-gray-600">Populasi</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($province->population) }}</p>
            </div>
        @endif

        @if($province->area)
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-600">Luas Wilayah</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($province->area, 2) }} km²</p>
            </div>
        @endif

        @if($province->timezone)
            <div class="bg-purple-50 p-4 rounded">
                <p class="text-sm text-gray-600">Zona Waktu</p>
                <p class="text-2xl font-bold text-purple-600">{{ $province->timezone }}</p>
            </div>
        @endif
    </div>

    @if($province->latitude && $province->longitude)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Koordinat</h3>
            <p class="text-gray-600">
                Latitude: {{ $province->latitude }}, Longitude: {{ $province->longitude }}
                @if($province->elevation)
                    | Elevasi: {{ $province->elevation }} m
                @endif
            </p>
        </div>
    @endif
</div>

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kabupaten/Kota di {{ $province->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($province->regencies as $regency)
            <a href="{{ route('wilayah.regency', $regency->code) }}"
               class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-blue-300 transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $regency->name }}</h3>
                        <p class="text-sm text-gray-600 capitalize">{{ $regency->type }}</p>
                    </div>
                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $regency->code }}</span>
                </div>
            </a>
        @empty
            <div class="col-span-full text-gray-500 text-center py-8">
                Tidak ada data kabupaten/kota
            </div>
        @endforelse
    </div>
</div>
@endsection
