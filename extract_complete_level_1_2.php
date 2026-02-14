<?php
/**
 * Complete extraction of ALL provinces and regencies from V2-V8 migration files
 * This script ensures we don't miss any records
 */

$sourceDir = '/tmp/indonesia-map/src/main/resources/db/migration';
$outputDir = __DIR__ . '/database/seeders/data';

$provinces = [];
$regencies = [];

$files = [
    'V2_22012026_2301__insert_wilayah_sumatera.sql',
    'V3_22012026_2302__insert_wilayah_jawa_bali.sql',
    'V4_22012026_2303__insert_wilayah_nusa_tenggara.sql',
    'V5_22012026_2304__insert_wilayah_kalimantan.sql',
    'V6_22012026_2305__insert_wilayah_sulawesi.sql',
    'V7_22012026_2306__insert_wilayah_maluku.sql',
    'V8_22012026_2307__insert_wilayah_papua.sql',
];

echo "Extracting complete Level 1 (Provinces) and Level 2 (Regencies) data...\n\n";

foreach ($files as $filename) {
    $filepath = "$sourceDir/$filename";

    if (!file_exists($filepath)) {
        echo "ERROR: File not found: $filepath\n";
        continue;
    }

    echo "Processing: $filename\n";

    $content = file_get_contents($filepath);
    $lines = explode("\n", $content);

    $inInsert = false;
    $currentInsert = '';
    $insertCount = 0;

    foreach ($lines as $lineNum => $line) {
        $line = trim($line);

        // Skip comments and empty lines
        if (empty($line) || strpos($line, '--') === 0) {
            continue;
        }

        // Start of INSERT statement
        if (preg_match('/^INSERT INTO\s+`?wilayah/i', $line)) {
            $inInsert = true;
            $currentInsert = $line;
            continue;
        }

        // Continue building multiline INSERT
        if ($inInsert) {
            $currentInsert .= ' ' . $line;

            // Check if this line ends the INSERT (ends with );)
            if (preg_match('/\);$/', $line)) {
                // Parse this complete INSERT statement
                parseInsert($currentInsert, $provinces, $regencies, $insertCount);

                $insertCount++;
                $inInsert = false;
                $currentInsert = '';
            }
        }
    }

    echo "  → Extracted $insertCount INSERT statements\n";
}

echo "\n=== EXTRACTION SUMMARY ===\n";
echo "Provinces: " . count($provinces) . "\n";
echo "Regencies: " . count($regencies) . "\n";
echo "Total: " . (count($provinces) + count($regencies)) . "\n\n";

// Save to JSON files
file_put_contents("$outputDir/provinces_complete.json", json_encode(array_values($provinces), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents("$outputDir/regencies_complete.json", json_encode(array_values($regencies), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "✅ Saved complete datasets:\n";
echo "   - provinces_complete.json (" . number_format(count($provinces)) . " records)\n";
echo "   - regencies_complete.json (" . number_format(count($regencies)) . " records)\n";

function parseInsert($insertStatement, &$provinces, &$regencies, $insertNum) {
    // Extract the VALUES part
    if (!preg_match('/VALUES\s*\((.*)\)/s', $insertStatement, $matches)) {
        echo "    WARNING: Could not extract VALUES from INSERT #$insertNum\n";
        return;
    }

    $valuesString = $matches[1];

    // Extract all quoted strings and numeric values
    $fields = extractFields($valuesString);

    if (count($fields) < 10) {
        echo "    WARNING: INSERT #$insertNum has only " . count($fields) . " fields (expected 11+)\n";
        return;
    }

    // Field mapping for wilayah_level_1_2:
    // 0: kode
    // 1: nama
    // 2: ibukota (for provinces) or NULL (for regencies)
    // 3: lat
    // 4: lng
    // 5: elv
    // 6: tz
    // 7: luas (area)
    // 8: penduduk (population)
    // 9: path (boundaries - large JSON string)
    // 10: status (1=province/kabupaten, 2=kota)

    $code = normalizeCode($fields[0]);
    $name = $fields[1];
    $ibukota = $fields[2];
    $latitude = $fields[3] !== 'NULL' ? (float)$fields[3] : null;
    $longitude = $fields[4] !== 'NULL' ? (float)$fields[4] : null;
    $elevation = $fields[5] !== 'NULL' ? (float)$fields[5] : null;
    $timezone = $fields[6] !== 'NULL' ? $fields[6] : null;
    $area = $fields[7] !== 'NULL' ? (float)$fields[7] : null;
    $population = $fields[8] !== 'NULL' ? (int)$fields[8] : null;
    $boundaries = $fields[9] !== 'NULL' ? $fields[9] : null;
    $status = isset($fields[10]) ? (int)$fields[10] : 1;

    // Determine if this is a province (2 digits) or regency (4 digits)
    if (strlen($code) == 2) {
        // Province
        $provinces[$code] = [
            'code' => $code,
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'elevation' => $elevation,
            'timezone' => $timezone,
            'area' => $area,
            'population' => $population,
            'boundaries' => $boundaries,
        ];
    } elseif (strlen($code) == 4) {
        // Regency
        $provinceCode = substr($code, 0, 2);
        $type = ($status == 2) ? 'kota' : 'kabupaten';

        $regencies[$code] = [
            'code' => $code,
            'province_code' => $provinceCode,
            'name' => $name,
            'type' => $type,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'elevation' => $elevation,
            'timezone' => $timezone,
            'area' => $area,
            'population' => $population,
            'boundaries' => $boundaries,
        ];
    } else {
        echo "    WARNING: Unexpected code length: '$code' (length " . strlen($code) . ")\n";
    }
}

function extractFields($valuesString) {
    $fields = [];
    $current = '';
    $inQuote = false;
    $quoteChar = null;
    $escaped = false;

    for ($i = 0; $i < strlen($valuesString); $i++) {
        $char = $valuesString[$i];

        if ($escaped) {
            $current .= $char;
            $escaped = false;
            continue;
        }

        if ($char === '\\') {
            $escaped = true;
            continue;
        }

        if (($char === '"' || $char === "'") && !$inQuote) {
            $inQuote = true;
            $quoteChar = $char;
            continue;
        }

        if ($char === $quoteChar && $inQuote) {
            $inQuote = false;
            $quoteChar = null;
            continue;
        }

        if ($char === ',' && !$inQuote) {
            $fields[] = trim($current);
            $current = '';
            continue;
        }

        $current .= $char;
    }

    // Add the last field
    if ($current !== '') {
        $fields[] = trim($current);
    }

    return $fields;
}

function normalizeCode($code) {
    // Remove quotes if present
    $code = trim($code, '"\'');

    // Handle dot-separated format: "11.01" -> "1101"
    if (strpos($code, '.') !== false) {
        $code = str_replace('.', '', $code);
    }

    return $code;
}
