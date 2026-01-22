@extends('layouts.app')

@section('title', $regency->name . ' - Wilayah Indonesia')

@section('content')
<div class="mb-6">
    <a href="{{ route('wilayah.province', $regency->province->code) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
        ← Kembali ke {{ $regency->province->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg p-8 mb-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">{{ $regency->name }}</h1>
            <p class="text-gray-600 mt-2 capitalize">{{ $regency->type }} | Kode: {{ $regency->code }}</p>
            <p class="text-blue-600 mt-1">{{ $regency->province->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($regency->population)
            <div class="bg-blue-50 p-4 rounded">
                <p class="text-sm text-gray-600">Populasi</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($regency->population) }}</p>
            </div>
        @endif

        @if($regency->area)
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-600">Luas Wilayah</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($regency->area, 2) }} km²</p>
            </div>
        @endif

        @if($regency->timezone)
            <div class="bg-purple-50 p-4 rounded">
                <p class="text-sm text-gray-600">Zona Waktu</p>
                <p class="text-2xl font-bold text-purple-600">{{ $regency->timezone }}</p>
            </div>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow-lg p-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kecamatan di {{ $regency->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($regency->districts as $district)
            <a href="{{ route('wilayah.district', $district->code) }}"
               class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-blue-300 transition">
                <div class="flex justify-between items-start">
                    <h3 class="font-semibold text-gray-800">{{ $district->name }}</h3>
                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $district->code }}</span>
                </div>
            </a>
        @empty
            <div class="col-span-full text-gray-500 text-center py-8">
                Tidak ada data kecamatan
            </div>
        @endforelse
    </div>
</div>

@if($regency->islands->count() > 0)
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Pulau di {{ $regency->name }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($regency->islands as $island)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="font-semibold text-gray-800">{{ $island->name }}</h3>
                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $island->code }}</span>
                    </div>
                    @if($island->is_outermost === 'ya')
                        <span class="inline-block mt-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Pulau Terluar</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
