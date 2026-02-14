<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $jsonFile = database_path('seeders/data/districts.json');

        if (!file_exists($jsonFile)) {
            $this->command->error("District data file not found: {$jsonFile}");
            return;
        }

        $districts = json_decode(file_get_contents($jsonFile), true);

        $this->command->info("Importing " . number_format(count($districts)) . " districts...");

        // Get valid regency codes
        $validRegencies = DB::table('regencies')->pluck('code')->toArray();

        // Process one by one to handle duplicates and missing foreign keys
        $count = 0;
        $skipped = 0;
        foreach ($districts as $index => $district) {
            // Skip if regency doesn't exist
            if (!in_array($district['regency_code'], $validRegencies)) {
                $skipped++;
                continue;
            }
            DB::table('districts')->updateOrInsert(
                ['code' => $district['code']],
                [
                    'regency_code' => $district['regency_code'],
                    'name' => $district['name'],
                    'latitude' => $district['latitude'],
                    'longitude' => $district['longitude'],
                    'area' => $district['area'],
                    'population' => $district['population'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $count++;
            if ($count % 500 == 0) {
                $this->command->info("Processed {$count} districts...");
            }
        }

        $this->command->info("Successfully imported {$count} districts");
        if ($skipped > 0) {
            $this->command->warn("Skipped {$skipped} districts with missing regency references");
        }
    }
}
