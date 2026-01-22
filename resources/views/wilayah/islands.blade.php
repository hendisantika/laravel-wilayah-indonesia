@extends('layouts.app')

@section('title', 'Daftar Pulau - Wilayah Indonesia')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Pulau-Pulau di Indonesia</h1>
    <p class="text-gray-600">Daftar pulau di Indonesia</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($islands as $island)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
            <div class="flex justify-between items-start mb-2">
                <h2 class="text-xl font-semibold text-gray-800">{{ $island->name }}</h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    {{ $island->code }}
                </span>
            </div>

            @if($island->regency)
                <p class="text-sm text-gray-600 mb-2">{{ $island->regency->name }}</p>
            @endif

            <div class="flex gap-2 mt-3">
                @if($island->is_outermost === 'ya')
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Pulau Terluar</span>
                @endif

                @if($island->is_populated === 'ya')
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Berpenghuni</span>
                @else
                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Tidak Berpenghuni</span>
                @endif
            </div>

            @if($island->area)
                <p class="text-sm text-gray-600 mt-3">
                    Luas: {{ number_format($island->area, 2) }} km²
                </p>
            @endif

            @if($island->latitude && $island->longitude)
                <p class="text-xs text-gray-500 mt-2">
                    {{ $island->latitude }}, {{ $island->longitude }}
                </p>
            @endif
        </div>
    @empty
        <div class="col-span-full bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Tidak ada data pulau. Silakan jalankan seeder terlebih dahulu.
        </div>
    @endforelse
</div>
@endsection
