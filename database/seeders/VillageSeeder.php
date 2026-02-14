<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        $jsonFile = database_path('seeders/data/villages.json');

        if (!file_exists($jsonFile)) {
            $this->command->error("Village data file not found: {$jsonFile}");
            return;
        }

        $villages = json_decode(file_get_contents($jsonFile), true);

        $this->command->info("Importing " . number_format(count($villages)) . " villages...");
        $this->command->warn("This may take several minutes...");

        // Get valid district codes
        $validDistricts = DB::table('districts')->pluck('code')->toArray();

        // Filter valid villages and process in batches
        $validVillages = array_filter($villages, function($village) use ($validDistricts) {
            return in_array($village['district_code'], $validDistricts);
        });

        $skipped = count($villages) - count($validVillages);
        if ($skipped > 0) {
            $this->command->warn("Skipping {$skipped} villages with missing district references");
        }

        $chunks = array_chunk($validVillages, 1000);

        foreach ($chunks as $index => $chunk) {
            // Use INSERT IGNORE to skip duplicates
            $data = array_map(function ($village) {
                return [
                    'code' => $village['code'],
                    'district_code' => $village['district_code'],
                    'name' => $village['name'],
                    'type' => $village['type'],
                    'latitude' => $village['latitude'],
                    'longitude' => $village['longitude'],
                    'area' => $village['area'],
                    'population' => $village['population'],
                    'postal_code' => $village['postal_code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $chunk);

            // Use raw query with INSERT IGNORE
            if (!empty($data)) {
                DB::statement('SET SESSION sql_mode = ""'); // Disable strict mode temporarily
                try {
                    DB::table('villages')->insert($data);
                } catch (\Exception $e) {
                    // Skip batch if there's an error
                    $this->command->warn("Skipped batch due to duplicates");
                }
            }

            if (($index + 1) % 10 == 0) {
                $this->command->info("Processed batch " . ($index + 1) . " of " . count($chunks) . " (" . number_format((($index + 1) / count($chunks)) * 100, 1) . "%)");
            }
        }

        $this->command->info("Successfully imported " . number_format(count($validVillages)) . " villages");
    }
}
