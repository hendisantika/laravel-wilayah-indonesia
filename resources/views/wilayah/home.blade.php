@extends('layouts.wilayah')

@section('title', 'Data Wilayah Administrasi Indonesia')

@section('content')
<div class="w3-card-4">
    <h2>&nbsp;</h2>
    <div class="w3-panel w3-bar w3-theme-d1">
        <h3 class="w3-theme-d1">Data Wilayah Administrasi Indonesia</h3>
        <h4 class="w3-theme-d1">Sesuai Kepmendagri No 300.2.2-2138 Tahun 2025</h4>
    </div>

    <div class="w3-container">
        <!-- Province Selection -->
        <div class="w3-row">
            <div class="w3-col m6 w3-padding">
                <label class="w3-col s6 m3">Pilih Provinsi</label>
                <div class="w3-col s6 m9">
                    <select name="prop" id="prop" class="w3-select w3-hover-theme w3-border" onchange="loadRegencies(this.value)">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Regency Selection -->
            <div class="w3-col m6 w3-padding" id="kab_box" style="display:none;">
                <label class="w3-col s6 m3">Pilih Kota/Kab</label>
                <div class="w3-col s6 m9">
                    <select name="kota" id="kota" class="w3-select w3-hover-theme w3-border" onchange="loadDistricts(this.value)">
                        <option value="">Pilih Kota/Kab</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- District Selection -->
        <div class="w3-row">
            <div class="w3-col m6 w3-padding" id="kec_box" style="display:none;">
                <label class="w3-col s6 m3">Pilih Kecamatan</label>
                <div class="w3-col s6 m9">
                    <select name="kec" id="kec" class="w3-select w3-hover-theme w3-border" onchange="loadVillages(this.value)">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>

            <!-- Village Selection -->
            <div class="w3-col m6 w3-padding" id="kel_box" style="display:none;">
                <label class="w3-col s6 m3">Pilih Kelurahan/Desa</label>
                <div class="w3-col s6 m9">
                    <select name="kel" id="kel" class="w3-select w3-hover-theme w3-border" onchange="showInfo(this.value, 'village')">
                        <option value="">Pilih Kelurahan/Desa</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Information Display -->
        <div class="w3-row w3-padding">
            <div class="w3-col m12">
                <div id="info_panel" class="w3-panel w3-theme-l5 w3-border w3-border-theme" style="display:none; min-height:200px;">
                    <h4>INFO</h4>
                    <div id="info_content"></div>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="preload" class="w3-bar w3-center" style="display:none;">
            <img src="{{ asset('img/preload.svg') }}" alt="Loading..." style="width:50px;">
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="w3-row-padding w3-margin-top">
    <div class="w3-quarter">
        <div class="w3-container w3-theme-d3 w3-padding-16">
            <div class="w3-left"><i class="w3-xxxlarge">📍</i></div>
            <div class="w3-right">
                <h3>{{ $stats['provinces'] }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Provinsi</h4>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-container w3-theme-d2 w3-padding-16">
            <div class="w3-left"><i class="w3-xxxlarge">🏘️</i></div>
            <div class="w3-right">
                <h3>{{ $stats['regencies'] }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Kota/Kabupaten</h4>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-container w3-theme-d1 w3-padding-16">
            <div class="w3-left"><i class="w3-xxxlarge">🏢</i></div>
            <div class="w3-right">
                <h3>{{ $stats['districts'] }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Kecamatan</h4>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-container w3-theme w3-padding-16">
            <div class="w3-left"><i class="w3-xxxlarge">🏠</i></div>
            <div class="w3-right">
                <h3>{{ $stats['villages'] }}</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Kelurahan/Desa</h4>
        </div>
    </div>
</div>

<div style="height: 100px;"></div>

@endsection

@push('scripts')
<script>
function loadRegencies(provinceCode) {
    if (!provinceCode) {
        document.getElementById('kab_box').style.display = 'none';
        document.getElementById('kec_box').style.display = 'none';
        document.getElementById('kel_box').style.display = 'none';
        document.getElementById('info_panel').style.display = 'none';
        return;
    }

    showLoading();

    fetch(`/api/v1/regencies?province_code=${provinceCode}`, {
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('kota');
        select.innerHTML = '<option value="">Pilih Kota/Kab</option>';

        data.data.forEach(regency => {
            const option = document.createElement('option');
            option.value = regency.code;
            option.textContent = regency.name;
            select.appendChild(option);
        });

        document.getElementById('kab_box').style.display = 'block';
        document.getElementById('kec_box').style.display = 'none';
        document.getElementById('kel_box').style.display = 'none';

        showInfo(provinceCode, 'province');
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
    });
}

function loadDistricts(regencyCode) {
    if (!regencyCode) {
        document.getElementById('kec_box').style.display = 'none';
        document.getElementById('kel_box').style.display = 'none';
        return;
    }

    showLoading();

    fetch(`/api/v1/districts?regency_code=${regencyCode}`, {
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('kec');
        select.innerHTML = '<option value="">Pilih Kecamatan</option>';

        data.data.forEach(district => {
            const option = document.createElement('option');
            option.value = district.code;
            option.textContent = district.name;
            select.appendChild(option);
        });

        document.getElementById('kec_box').style.display = 'block';
        document.getElementById('kel_box').style.display = 'none';

        showInfo(regencyCode, 'regency');
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
    });
}

function loadVillages(districtCode) {
    if (!districtCode) {
        document.getElementById('kel_box').style.display = 'none';
        return;
    }

    showLoading();

    fetch(`/api/v1/villages?district_code=${districtCode}`, {
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('kel');
        select.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

        data.data.forEach(village => {
            const option = document.createElement('option');
            option.value = village.code;
            option.textContent = village.name;
            select.appendChild(option);
        });

        document.getElementById('kel_box').style.display = 'block';

        showInfo(districtCode, 'district');
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
    });
}

function showInfo(code, type) {
    showLoading();

    const endpoints = {
        'province': `/api/v1/provinces/${code}`,
        'regency': `/api/v1/regencies/${code}`,
        'district': `/api/v1/districts/${code}`,
        'village': `/api/v1/villages/${code}`
    };

    fetch(endpoints[type], {
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(result => {
        const data = result.data;
        let html = `
            <table class="w3-table w3-bordered">
                <tr><td><strong>Kode</strong></td><td>${data.code}</td></tr>
                <tr><td><strong>Nama</strong></td><td>${data.name}</td></tr>
        `;

        if (data.ibukota) {
            html += `<tr><td><strong>Ibukota</strong></td><td>${data.ibukota}</td></tr>`;
        }
        if (data.type) {
            html += `<tr><td><strong>Tipe</strong></td><td>${data.type}</td></tr>`;
        }
        if (data.latitude) {
            html += `<tr><td><strong>Koordinat</strong></td><td>${data.latitude}, ${data.longitude}</td></tr>`;
        }
        if (data.area) {
            html += `<tr><td><strong>Luas</strong></td><td>${data.area} km²</td></tr>`;
        }
        if (data.population) {
            html += `<tr><td><strong>Populasi</strong></td><td>${parseInt(data.population).toLocaleString('id-ID')}</td></tr>`;
        }
        if (data.postal_code) {
            html += `<tr><td><strong>Kode Pos</strong></td><td>${data.postal_code}</td></tr>`;
        }

        html += '</table>';

        document.getElementById('info_content').innerHTML = html;
        document.getElementById('info_panel').style.display = 'block';
        hideLoading();
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoading();
    });
}

function showLoading() {
    document.getElementById('preload').style.display = 'block';
}

function hideLoading() {
    document.getElementById('preload').style.display = 'none';
}
</script>
@endpush
