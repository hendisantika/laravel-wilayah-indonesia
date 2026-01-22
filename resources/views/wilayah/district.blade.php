@extends('layouts.app')

@section('title', $district->name . ' - Wilayah Indonesia')

@section('content')
<div class="mb-6">
    <a href="{{ route('wilayah.regency', $district->regency->code) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
        ← Kembali ke {{ $district->regency->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg p-8 mb-8">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-gray-800">{{ $district->name }}</h1>
        <p class="text-gray-600 mt-2">Kecamatan | Kode: {{ $district->code }}</p>
        <p class="text-blue-600 mt-1">
            {{ $district->regency->name }}, {{ $district->regency->province->name }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($district->population)
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm text-gray-600">Populasi</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($district->population) }}</p>
            </div>
        @endif

        @if($district->area)
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-600">Luas Wilayah</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($district->area, 2) }} km²</p>
            </div>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Desa/Kelurahan di {{ $district->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($district->villages as $village)
            <a href="{{ route('wilayah.village', $village->code) }}"
               class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-blue-300 transition">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-gray-800">{{ $village->name }}</h3>
                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $village->code }}</span>
                </div>
                <p class="text-sm text-gray-600 capitalize">{{ $village->type }}</p>
            </a>
        @empty
            <div class="col-span-full text-gray-500 text-center py-8">
                Tidak ada data desa/kelurahan
            </div>
        @endforelse
    </div>
</div>
@endsection
