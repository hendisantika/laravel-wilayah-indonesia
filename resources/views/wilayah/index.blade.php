@extends('layouts.app')

@section('title', 'Daftar Provinsi - Wilayah Indonesia')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Provinsi di Indonesia</h1>
    <p class="text-gray-600">Daftar lengkap provinsi di Indonesia</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($provinces as $province)
        <a href="{{ route('wilayah.province', $province->code) }}"
           class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 block">
            <div class="flex justify-between items-start mb-2">
                <h2 class="text-xl font-semibold text-gray-800">{{ $province->name }}</h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    {{ $province->code }}
                </span>
            </div>

            <div class="text-sm text-gray-600 space-y-1 mt-4">
                @if($province->regencies_count)
                    <p>Kabupaten/Kota: <span class="font-medium">{{ $province->regencies_count }}</span></p>
                @endif

                @if($province->population)
                    <p>Populasi: <span class="font-medium">{{ number_format($province->population) }}</span></p>
                @endif

                @if($province->area)
                    <p>Luas: <span class="font-medium">{{ number_format($province->area, 2) }} km²</span></p>
                @endif
            </div>
        </a>
    @empty
        <div class="col-span-full bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Tidak ada data provinsi. Silakan jalankan seeder terlebih dahulu.
        </div>
    @endforelse
</div>
@endsection
