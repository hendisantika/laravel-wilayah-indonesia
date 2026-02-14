<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $jsonFile = database_path('seeders/data/provinces.json');

        if (!file_exists($jsonFile)) {
            $this->command->error("Province data file not found: {$jsonFile}");
            return;
        }

        $provinces = json_decode(file_get_contents($jsonFile), true);

        $this->command->info("Importing " . count($provinces) . " provinces...");

        foreach ($provinces as $province) {
            DB::table('provinces')->updateOrInsert(
                ['code' => $province['code']],
                [
                    'name' => $province['name'],
                    'latitude' => $province['latitude'],
                    'longitude' => $province['longitude'],
                    'elevation' => $province['elevation'],
                    'timezone' => $province['timezone'],
                    'area' => $province['area'],
                    'population' => $province['population'],
                    'boundaries' => $province['boundaries'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info("Successfully imported " . count($provinces) . " provinces");
    }
}
