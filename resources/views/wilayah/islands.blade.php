@extends('layouts.wilayah')

@section('title', 'Daftar Pulau - Wilayah Indonesia')

@section('content')
<div class="w3-card-4">
    <div class="w3-panel w3-bar w3-theme-d1">
        <h3 class="w3-theme-d1">Pulau-Pulau di Indonesia</h3>
        <h4 class="w3-theme-d1">Daftar Pulau di Wilayah Indonesia</h4>
    </div>

    <div class="w3-container w3-padding">
        <div class="w3-row-padding">
            @forelse($islands as $island)
                <div class="w3-col m4 l3 w3-padding">
                    <div class="w3-card-4 w3-hover-shadow">
                        <header class="w3-container w3-theme-d3">
                            <h4>{{ $island->name }}</h4>
                        </header>

                        <div class="w3-container">
                            @if($island->regency)
                                <p><strong>Kabupaten/Kota:</strong> {{ $island->regency->name }}</p>
                            @endif

                            <p><strong>Kode:</strong> {{ $island->code }}</p>

                            @if($island->area)
                                <p><strong>Luas:</strong> {{ number_format($island->area, 2) }} km²</p>
                            @endif

                            <div class="w3-row w3-margin-top">
                                @if($island->is_outermost === 'ya')
                                    <span class="w3-tag w3-red w3-tiny">Pulau Terluar</span>
                                @endif

                                @if($island->is_populated === 'ya')
                                    <span class="w3-tag w3-green w3-tiny">Berpenghuni</span>
                                @else
                                    <span class="w3-tag w3-gray w3-tiny">Tidak Berpenghuni</span>
                                @endif
                            </div>

                            @if($island->latitude && $island->longitude)
                                <p class="w3-tiny w3-text-gray w3-margin-top">
                                    📍 {{ $island->latitude }}, {{ $island->longitude }}
                                </p>
                            @endif

                            @if($island->notes)
                                <p class="w3-tiny w3-text-gray">
                                    <em>{{ $island->notes }}</em>
                                </p>
                            @endif
                        </div>

                        <div style="height: 10px;"></div>
                    </div>
                </div>
            @empty
                <div class="w3-col m12 w3-padding">
                    <div class="w3-panel w3-pale-yellow w3-border w3-border-yellow">
                        <p>Tidak ada data pulau. Silakan jalankan seeder terlebih dahulu.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div style="height: 100px;"></div>
@endsection
