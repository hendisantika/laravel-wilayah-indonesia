<?php
/**
 * Extract supplemental data from V16-V24 migration files
 * These add/fix administrative units not in the base HDX 2020 data
 */

$outputDir = __DIR__ . '/database/seeders/data';

// Load existing data
$districts = json_decode(file_get_contents("$outputDir/districts.json"), true);
$villages = json_decode(file_get_contents("$outputDir/villages.json"), true);

echo "=== Extracting Supplemental Data ===\n\n";

// Add Kecamatan Cangkuang (from V16)
// Code: 32.04.44 -> 320444
$cangkuangCode = '320444';
if (!isset($districts[$cangkuangCode])) {
    $districts[$cangkuangCode] = [
        'code' => $cangkuangCode,
        'regency_code' => '3204', // Kabupaten Bandung
        'name' => 'Cangkuang',
        'latitude' => -7.0236,
        'longitude' => 107.6420,
        'area' => null,
        'population' => null,
    ];
    echo "✅ Added District: Cangkuang (320444)\n";
} else {
    echo "ℹ️  District Cangkuang (320444) already exists\n";
}

// Add Cangkuang villages (from V17) - 7 villages
$cangkuangVillages = [
    ['code' => '3204442001', 'name' => 'Cangkuang', 'type' => 'desa'],
    ['code' => '3204442002', 'name' => 'Ciluncat', 'type' => 'desa'],
    ['code' => '3204442003', 'name' => 'Nagrak', 'type' => 'desa'],
    ['code' => '3204442004', 'name' => 'Bandasari', 'type' => 'desa'],
    ['code' => '3204442005', 'name' => 'Pananjung', 'type' => 'desa'],
    ['code' => '3204442006', 'name' => 'Jatisari', 'type' => 'desa'],
    ['code' => '3204442007', 'name' => 'Tanjungsari', 'type' => 'desa'],
];

$addedVillages = 0;
foreach ($cangkuangVillages as $v) {
    if (!isset($villages[$v['code']])) {
        $villages[$v['code']] = [
            'code' => $v['code'],
            'district_code' => $cangkuangCode,
            'name' => $v['name'],
            'type' => $v['type'],
            'latitude' => null,
            'longitude' => null,
            'area' => null,
            'population' => null,
            'postal_code' => null,
        ];
        $addedVillages++;
    }
}

echo "✅ Added $addedVillages Cangkuang villages\n";

// Update Banjaran villages (from V17) - ensure correct district
$banjaranCode = '320413';
$banjaranVillages = [
    '3204132001', '3204132002', '3204132003', '3204132005', '3204132006',
    '3204132007', '3204132008', '3204132012', '3204132013', '3204132016', '3204132018'
];

$updatedBanjaran = 0;
foreach ($banjaranVillages as $vCode) {
    if (isset($villages[$vCode])) {
        if ($villages[$vCode]['district_code'] !== $banjaranCode) {
            $villages[$vCode]['district_code'] = $banjaranCode;
            $updatedBanjaran++;
        }
    }
}

if ($updatedBanjaran > 0) {
    echo "✅ Updated $updatedBanjaran Banjaran villages to correct district\n";
}

// Save updated data
file_put_contents("$outputDir/districts.json", json_encode(array_values($districts), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents("$outputDir/villages.json", json_encode(array_values($villages), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "\n=== Summary ===\n";
echo "Districts: " . count($districts) . "\n";
echo "Villages: " . count($villages) . "\n";
echo "\n✅ Supplemental data extraction complete\n";
