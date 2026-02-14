<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $jsonFile = database_path('seeders/data/regencies.json');

        if (!file_exists($jsonFile)) {
            $this->command->error("Regency data file not found: {$jsonFile}");
            return;
        }

        $regencies = json_decode(file_get_contents($jsonFile), true);

        $this->command->info("Importing " . count($regencies) . " regencies...");

        // Process in batches of 100 for better performance
        $chunks = array_chunk($regencies, 100);

        foreach ($chunks as $index => $chunk) {
            foreach ($chunk as $regency) {
                DB::table('regencies')->updateOrInsert(
                    ['code' => $regency['code']],
                    [
                        'province_code' => $regency['province_code'],
                        'name' => $regency['name'],
                        'type' => $regency['type'],
                        'latitude' => $regency['latitude'],
                        'longitude' => $regency['longitude'],
                        'elevation' => $regency['elevation'],
                        'timezone' => $regency['timezone'],
                        'area' => $regency['area'],
                        'population' => $regency['population'],
                        'boundaries' => $regency['boundaries'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $this->command->info("Processed batch " . ($index + 1) . " of " . count($chunks));
        }

        $this->command->info("Successfully imported " . count($regencies) . " regencies");
    }
}
