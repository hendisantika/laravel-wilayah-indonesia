<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Island;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProvinces();
        $this->seedRegencies();
        $this->seedDistricts();
        $this->seedVillages();
        $this->seedIslands();
    }

    private function seedProvinces(): void
    {
        $provinces = [
            [
                'code' => '11',
                'name' => 'ACEH',
                'ibukota' => 'Banda Aceh',
                'latitude' => 4.695135,
                'longitude' => 96.749397,
                'elevation' => 125.00,
                'timezone' => 'WIB',
                'area' => 57956.00,
                'population' => 5274871,
                'status' => 1,
            ],
            [
                'code' => '12',
                'name' => 'SUMATERA UTARA',
                'ibukota' => 'Medan',
                'latitude' => 2.115262,
                'longitude' => 99.545097,
                'elevation' => 245.00,
                'timezone' => 'WIB',
                'area' => 72981.00,
                'population' => 14799361,
                'status' => 1,
            ],
            [
                'code' => '31',
                'name' => 'DKI JAKARTA',
                'ibukota' => 'Jakarta',
                'latitude' => -6.208763,
                'longitude' => 106.845599,
                'elevation' => 7.00,
                'timezone' => 'WIB',
                'area' => 664.01,
                'population' => 10562088,
                'status' => 1,
            ],
            [
                'code' => '32',
                'name' => 'JAWA BARAT',
                'ibukota' => 'Bandung',
                'latitude' => -7.090911,
                'longitude' => 107.668887,
                'elevation' => 667.00,
                'timezone' => 'WIB',
                'area' => 35377.76,
                'population' => 48037827,
                'status' => 1,
            ],
            [
                'code' => '33',
                'name' => 'JAWA TENGAH',
                'ibukota' => 'Semarang',
                'latitude' => -7.150975,
                'longitude' => 110.140259,
                'elevation' => 269.00,
                'timezone' => 'WIB',
                'area' => 32800.69,
                'population' => 36516035,
                'status' => 1,
            ],
            [
                'code' => '35',
                'name' => 'JAWA TIMUR',
                'ibukota' => 'Surabaya',
                'latitude' => -7.536764,
                'longitude' => 112.238184,
                'elevation' => 318.00,
                'timezone' => 'WIB',
                'area' => 47800.00,
                'population' => 40665696,
                'status' => 1,
            ],
            [
                'code' => '51',
                'name' => 'BALI',
                'ibukota' => 'Denpasar',
                'latitude' => -8.409518,
                'longitude' => 115.188919,
                'elevation' => 284.00,
                'timezone' => 'WITA',
                'area' => 5780.06,
                'population' => 4317404,
                'status' => 1,
            ],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }

    private function seedRegencies(): void
    {
        $regencies = [
            [
                'code' => '1101',
                'province_code' => '11',
                'name' => 'KAB. ACEH SELATAN',
                'ibukota' => 'Tapak Tuan',
                'type' => 'kabupaten',
                'latitude' => 3.226093,
                'longitude' => 97.418397,
                'area' => 3841.60,
                'population' => 232414,
                'status' => 1,
            ],
            [
                'code' => '1171',
                'province_code' => '11',
                'name' => 'KOTA BANDA ACEH',
                'ibukota' => 'Banda Aceh',
                'type' => 'kota',
                'latitude' => 5.548291,
                'longitude' => 95.323753,
                'area' => 61.36,
                'population' => 252899,
                'status' => 1,
            ],
            [
                'code' => '3101',
                'province_code' => '31',
                'name' => 'KAB. ADM. KEPULAUAN SERIBU',
                'ibukota' => 'Pramuka',
                'type' => 'kabupaten',
                'latitude' => -5.610658,
                'longitude' => 106.601173,
                'area' => 8.76,
                'population' => 24300,
                'status' => 1,
            ],
            [
                'code' => '3171',
                'province_code' => '31',
                'name' => 'KOTA ADM. JAKARTA PUSAT',
                'ibukota' => 'Menteng',
                'type' => 'kota',
                'latitude' => -6.186486,
                'longitude' => 106.834091,
                'area' => 48.13,
                'population' => 928204,
                'status' => 1,
            ],
            [
                'code' => '3201',
                'province_code' => '32',
                'name' => 'KAB. BOGOR',
                'ibukota' => 'Cibinong',
                'type' => 'kabupaten',
                'latitude' => -6.595038,
                'longitude' => 106.789185,
                'area' => 2986.95,
                'population' => 5715009,
                'status' => 1,
            ],
            [
                'code' => '3273',
                'province_code' => '32',
                'name' => 'KOTA BANDUNG',
                'ibukota' => 'Bandung',
                'type' => 'kota',
                'latitude' => -6.917464,
                'longitude' => 107.619123,
                'area' => 167.67,
                'population' => 2444160,
                'status' => 1,
            ],
        ];

        foreach ($regencies as $regency) {
            Regency::create($regency);
        }
    }

    private function seedDistricts(): void
    {
        $districts = [
            [
                'code' => '110101',
                'regency_code' => '1101',
                'name' => 'Bakongan',
                'latitude' => 3.226093,
                'longitude' => 97.418397,
                'area' => 157.00,
                'population' => 11234,
            ],
            [
                'code' => '110102',
                'regency_code' => '1101',
                'name' => 'Kluet Utara',
                'latitude' => 3.384523,
                'longitude' => 97.521345,
                'area' => 423.50,
                'population' => 15678,
            ],
            [
                'code' => '117101',
                'regency_code' => '1171',
                'name' => 'Meuraxa',
                'latitude' => 5.563252,
                'longitude' => 95.360187,
                'area' => 7.25,
                'population' => 28456,
            ],
            [
                'code' => '320101',
                'regency_code' => '3201',
                'name' => 'Nanggung',
                'latitude' => -6.536874,
                'longitude' => 106.677452,
                'area' => 87.45,
                'population' => 42345,
            ],
            [
                'code' => '327301',
                'regency_code' => '3273',
                'name' => 'Bandung Wetan',
                'latitude' => -6.902441,
                'longitude' => 107.625183,
                'area' => 2.15,
                'population' => 45123,
            ],
        ];

        foreach ($districts as $district) {
            District::create($district);
        }
    }

    private function seedVillages(): void
    {
        $villages = [
            [
                'code' => '1101012001',
                'district_code' => '110101',
                'name' => 'Keude Bakongan',
                'type' => 'desa',
                'latitude' => 3.226093,
                'longitude' => 97.418397,
                'area' => 12.50,
                'population' => 2345,
                'postal_code' => '23719',
            ],
            [
                'code' => '1101012002',
                'district_code' => '110101',
                'name' => 'Kuala Baru',
                'type' => 'desa',
                'latitude' => 3.235678,
                'longitude' => 97.425123,
                'area' => 15.30,
                'population' => 1876,
                'postal_code' => '23719',
            ],
            [
                'code' => '1171011001',
                'district_code' => '117101',
                'name' => 'Punge Blang Cut',
                'type' => 'kelurahan',
                'latitude' => 5.563252,
                'longitude' => 95.360187,
                'area' => 1.25,
                'population' => 4567,
                'postal_code' => '23249',
            ],
            [
                'code' => '3201012001',
                'district_code' => '320101',
                'name' => 'Bantar Karet',
                'type' => 'desa',
                'latitude' => -6.536874,
                'longitude' => 106.677452,
                'area' => 8.75,
                'population' => 5432,
                'postal_code' => '16650',
            ],
            [
                'code' => '3273011001',
                'district_code' => '327301',
                'name' => 'Cihapit',
                'type' => 'kelurahan',
                'latitude' => -6.902441,
                'longitude' => 107.625183,
                'area' => 0.45,
                'population' => 8234,
                'postal_code' => '40114',
            ],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }
    }

    private function seedIslands(): void
    {
        $islands = [
            [
                'code' => '110100001',
                'regency_code' => '1101',
                'name' => 'Pulau Bangkaru',
                'latitude' => 2.838611,
                'longitude' => 96.165278,
                'area' => 11.50,
                'is_outermost' => 'ya',
                'is_populated' => 'tidak',
                'notes' => 'TBP',
            ],
            [
                'code' => '110100002',
                'regency_code' => '1101',
                'name' => 'Pulau Tuangku',
                'latitude' => 2.646389,
                'longitude' => 95.906944,
                'area' => 7.80,
                'is_outermost' => 'ya',
                'is_populated' => 'tidak',
                'notes' => 'TBP',
            ],
            [
                'code' => '310100001',
                'regency_code' => '3101',
                'name' => 'Pulau Tidung Besar',
                'latitude' => -5.794722,
                'longitude' => 106.507222,
                'area' => 1.05,
                'is_outermost' => 'tidak',
                'is_populated' => 'ya',
                'notes' => 'BP',
            ],
            [
                'code' => '310100002',
                'regency_code' => '3101',
                'name' => 'Pulau Pramuka',
                'latitude' => -5.744722,
                'longitude' => 106.611667,
                'area' => 0.16,
                'is_outermost' => 'tidak',
                'is_populated' => 'ya',
                'notes' => 'BP',
            ],
        ];

        foreach ($islands as $island) {
            Island::create($island);
        }
    }
}
