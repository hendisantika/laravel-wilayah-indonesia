# Indonesia Administrative Data Integration Summary

## Overview

Successfully integrated complete administrative data for Indonesia from the [indonesia-map repository](https://github.com/hendisantika/indonesia-map) into this Laravel project.

## Integrated Data

### ✅ Provinces (Level 1)
- **Total**: 38 provinces
- **Data includes**:
  - Province code (2 digits)
  - Province name
  - Geographic coordinates (latitude, longitude, elevation)
  - Timezone
  - Area (km²)
  - Population
  - Geographic boundaries (GeoJSON format)

### ✅ Regencies/Cities (Level 2)
- **Total**: 495 regencies and cities
- **Data includes**:
  - Regency code (4 digits)
  - Province code (foreign key)
  - Regency name
  - Type (kabupaten or kota)
  - Geographic coordinates (latitude, longitude, elevation)
  - Timezone
  - Area (km²)
  - Population
  - Geographic boundaries (GeoJSON format)

## Regional Breakdown

| Region | Provinces | Regencies | Source File |
|--------|-----------|-----------|-------------|
| Sumatera | 10 | ~160 | V2_insert_wilayah_sumatera.sql |
| Jawa & Bali | 7 | ~133 | V3_insert_wilayah_jawa_bali.sql |
| Nusa Tenggara | 3 | ~34 | V4_insert_wilayah_nusa_tenggara.sql |
| Kalimantan | 5 | ~61 | V5_insert_wilayah_kalimantan.sql |
| Sulawesi | 6 | ~87 | V6_insert_wilayah_sulawesi.sql |
| Maluku | 2 | ~23 | V7_insert_wilayah_maluku.sql |
| Papua | 6 | ~48 | V8_insert_wilayah_papua.sql |
| **TOTAL** | **38** | **495** | |

## Database Schema

### provinces table
```sql
- code (char 2, primary key)
- name (varchar)
- latitude (decimal 10,7)
- longitude (decimal 10,7)
- elevation (decimal 8,2)
- timezone (varchar 50)
- area (decimal 12,2)
- population (bigint)
- boundaries (longtext) -- GeoJSON polygon data
- timestamps
```

### regencies table
```sql
- code (char 4, primary key)
- province_code (char 2, foreign key -> provinces.code)
- name (varchar)
- type (enum: 'kabupaten', 'kota')
- latitude (decimal 10,7)
- longitude (decimal 10,7)
- elevation (decimal 8,2)
- timezone (varchar 50)
- area (decimal 12,2)
- population (bigint)
- boundaries (longtext) -- GeoJSON polygon data
- timestamps
```

## Files Created

### Seeders
- `database/seeders/ProvinceSeeder.php` - Seeds provinces from JSON data
- `database/seeders/RegencySeeder.php` - Seeds regencies from JSON data
- `database/seeders/data/provinces.json` - Province data (38 records)
- `database/seeders/data/regencies.json` - Regency data (495 records)

### Migrations
- `2026_02_14_223135_update_boundaries_column_type.php` - Updates boundaries column to longText to accommodate large GeoJSON data

### Conversion Scripts
- `convert_sql_to_seeders.php` - Initial converter (deprecated)
- `convert_sql_to_seeders_v2.php` - Improved converter that handles dot-separated codes

## Usage

### Running the Seeders

```bash
# Seed provinces only
php artisan db:seed --class=ProvinceSeeder

# Seed regencies only
php artisan db:seed --class=RegencySeeder

# Seed all (via DatabaseSeeder)
php artisan db:seed
```

### Querying the Data

```php
// Get all provinces
$provinces = DB::table('provinces')->get();

// Get regencies for a specific province
$regencies = DB::table('regencies')
    ->where('province_code', '11')
    ->get();

// Get province with its regencies
$province = DB::table('provinces')->find('11');
$regencies = DB::table('regencies')
    ->where('province_code', $province->code)
    ->get();

// Get regency with its province
$regency = DB::table('regencies')->find('1101');
$province = DB::table('provinces')->find($regency->province_code);
```

## Notes on Districts and Villages

The source repository also contains data for:
- **Districts (Level 3)**: ~7,069 records in V9.x migration files
- **Villages (Level 4)**: ~81,911 records in V10.x migration files

These are stored in a different format with PostGIS spatial data and were not integrated in this initial phase. They can be added later if needed.

## Data Source

- **Repository**: https://github.com/hendisantika/indonesia-map
- **License**: MIT License
- **Author**: cahya dsn (cahyadsn@gmail.com)
- **Reference**: Kepmendagri No 300.2.2-2138 Tahun 2025
- **Level 3-4 Source**: HDX Indonesia COD-AB (Humanitarian Data Exchange)
- **Date**: 2020-04-01 (BPS Data)

## Migration Process

1. ✅ Cloned source repository locally
2. ✅ Created converter script to parse SQL INSERT statements
3. ✅ Handled dot-separated code format (e.g., "11.01" → "1101")
4. ✅ Extracted provinces and regencies from V2-V8 migration files
5. ✅ Generated JSON data files
6. ✅ Created Laravel seeders
7. ✅ Updated database schema for large boundaries data
8. ✅ Successfully imported all data

## Verification

```bash
# Check counts
php artisan tinker
>>> DB::table('provinces')->count()
=> 38
>>> DB::table('regencies')->count()
=> 495

# View sample data
>>> DB::table('provinces')->limit(5)->get()
>>> DB::table('regencies')->limit(5)->get()
```

## Next Steps (Optional)

If you need district and village data:

1. Parse V9.x migration files for districts (Level 3)
2. Parse V10.x migration files for villages (Level 4)
3. Create district and village seeders
4. Consider adding spatial database support for complex boundaries
5. Total additional records: ~89,000

---

**Integration Date**: 2026-02-14
**Status**: ✅ Complete (Provinces & Regencies)
**Total Records**: 533 (38 provinces + 495 regencies)
