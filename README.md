# Wilayah Indonesia - Laravel

A comprehensive Laravel application for managing Indonesian administrative region data (wilayah Indonesia) with a hierarchical structure, RESTful API, and modern web interface.

## Features

- **Hierarchical Data Structure**: Provinces → Regencies/Cities → Districts → Villages + Islands
- **RESTful API**: Full CRUD operations with filtering and relationship loading
- **Modern Web Interface**: Responsive design with Tailwind CSS
- **Comprehensive Testing**: Pest test suites for API and web features
- **Database Seeding**: Sample data from major Indonesian provinces
- **Geographic Data**: Latitude, longitude, elevation, area, and population statistics

## System Requirements

- PHP 8.2+
- Composer
- Laravel 12
- MySQL/PostgreSQL/SQLite

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd wilayah-indonesia
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wilayah_indonesia
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

6. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` to see the application.

## Database Structure

### Tables

#### provinces
- **code** (char 2): Primary key - Province code
- **name** (string): Province name
- **latitude/longitude** (decimal): Geographic coordinates
- **elevation** (decimal): Elevation in meters
- **timezone** (string): Time zone (WIB/WITA/WIT)
- **area** (decimal): Area in km²
- **population** (bigint): Population count
- **boundaries** (text): Administrative boundaries

#### regencies
- **code** (char 4): Primary key - Regency/City code
- **province_code** (char 2): Foreign key to provinces
- **name** (string): Regency/City name
- **type** (enum): 'kabupaten' or 'kota'
- Geographic and population data similar to provinces

#### districts
- **code** (char 6): Primary key - District code
- **regency_code** (char 4): Foreign key to regencies
- **name** (string): District name (kecamatan)
- Geographic and population data

#### villages
- **code** (char 10): Primary key - Village code
- **district_code** (char 6): Foreign key to districts
- **name** (string): Village name
- **type** (enum): 'desa' or 'kelurahan'
- **postal_code** (string): Postal code
- Geographic and population data

#### islands
- **code** (char 9): Primary key - Island code
- **regency_code** (char 4): Foreign key to regencies (nullable)
- **name** (string): Island name
- **is_outermost** (enum): 'ya' or 'tidak'
- **is_populated** (enum): 'ya' or 'tidak'
- Geographic data

## API Endpoints

All API endpoints are prefixed with `/api/v1/`.

### Provinces

```
GET    /api/v1/provinces              - List all provinces
POST   /api/v1/provinces              - Create new province
GET    /api/v1/provinces/{code}       - Show province details
PUT    /api/v1/provinces/{code}       - Update province
DELETE /api/v1/provinces/{code}       - Delete province
```

**Query Parameters:**
- `with_regencies` - Include regencies relationship
- `search` - Search by name

**Example:**
```bash
curl http://localhost:8000/api/v1/provinces?with_regencies=1
```

### Regencies

```
GET    /api/v1/regencies              - List all regencies
POST   /api/v1/regencies              - Create new regency
GET    /api/v1/regencies/{code}       - Show regency details
PUT    /api/v1/regencies/{code}       - Update regency
DELETE /api/v1/regencies/{code}       - Delete regency
```

**Query Parameters:**
- `province_code` - Filter by province
- `type` - Filter by type (kabupaten/kota)
- `with_province` - Include province relationship
- `with_districts` - Include districts relationship
- `with_islands` - Include islands relationship
- `search` - Search by name

### Districts

```
GET    /api/v1/districts              - List all districts
POST   /api/v1/districts              - Create new district
GET    /api/v1/districts/{code}       - Show district details
PUT    /api/v1/districts/{code}       - Update district
DELETE /api/v1/districts/{code}       - Delete district
```

**Query Parameters:**
- `regency_code` - Filter by regency
- `with_regency` - Include regency relationship
- `with_villages` - Include villages relationship
- `search` - Search by name

### Villages

```
GET    /api/v1/villages               - List all villages
POST   /api/v1/villages               - Create new village
GET    /api/v1/villages/{code}        - Show village details
PUT    /api/v1/villages/{code}        - Update village
DELETE /api/v1/villages/{code}        - Delete village
```

**Query Parameters:**
- `district_code` - Filter by district
- `type` - Filter by type (desa/kelurahan)
- `with_district` - Include district relationship
- `search` - Search by name

### Islands

```
GET    /api/v1/islands                - List all islands
POST   /api/v1/islands                - Create new island
GET    /api/v1/islands/{code}         - Show island details
PUT    /api/v1/islands/{code}         - Update island
DELETE /api/v1/islands/{code}         - Delete island
```

**Query Parameters:**
- `regency_code` - Filter by regency
- `is_outermost` - Filter by outermost status
- `is_populated` - Filter by populated status
- `with_regency` - Include regency relationship
- `search` - Search by name

## Web Routes

- `/` - Home page (province listing)
- `/wilayah/provinces/{code}` - Province detail page
- `/wilayah/regencies/{code}` - Regency detail page
- `/wilayah/districts/{code}` - District detail page
- `/wilayah/villages/{code}` - Village detail page
- `/wilayah/islands` - Islands listing page

## Running Tests

Run all tests:
```bash
php artisan test
```

Run specific test suite:
```bash
php artisan test --filter ProvinceApiTest
php artisan test --filter RegencyApiTest
php artisan test --filter WilayahWebTest
```

## Sample Data

The seeder includes sample data for:
- 7 provinces (Aceh, North Sumatra, Jakarta, West Java, Central Java, East Java, Bali)
- 6 regencies/cities
- 5 districts
- 5 villages
- 4 islands

## Development

### Adding More Data

To add more data, you can:

1. **Via API**: Use POST endpoints to create new records
2. **Via Seeder**: Modify `database/seeders/WilayahSeeder.php`
3. **Via SQL**: Import SQL files directly to the database

### Customization

- **Models**: Located in `app/Models/`
- **Controllers**: API controllers in `app/Http/Controllers/Api/`, web controller in `app/Http/Controllers/WilayahController.php`
- **Resources**: JSON resources in `app/Http/Resources/`
- **Views**: Blade templates in `resources/views/wilayah/`
- **Routes**: API routes in `routes/api.php`, web routes in `routes/web.php`

## Technology Stack

- **Framework**: Laravel 12
- **Testing**: Pest
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL/PostgreSQL/SQLite
- **API**: RESTful JSON API

## Credits

Data structure based on [cahyadsn/wilayah](https://github.com/cahyadsn/wilayah) repository following Kepmendagri No 300.2.2-2138 Tahun 2025.

Built with Laravel following modern best practices and clean architecture principles.

## License

MIT License
