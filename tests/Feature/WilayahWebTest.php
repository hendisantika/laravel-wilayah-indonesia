<?php

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

beforeEach(function () {
    $this->province = Province::create([
        'code' => '99',
        'name' => 'TEST PROVINCE',
        'population' => 1000000,
        'area' => 1000.00,
    ]);

    $this->regency = Regency::create([
        'code' => '9901',
        'province_code' => '99',
        'name' => 'TEST REGENCY',
        'type' => 'kabupaten',
    ]);

    $this->district = District::create([
        'code' => '990101',
        'regency_code' => '9901',
        'name' => 'TEST DISTRICT',
    ]);

    $this->village = Village::create([
        'code' => '9901012001',
        'district_code' => '990101',
        'name' => 'TEST VILLAGE',
        'type' => 'desa',
    ]);
});

test('home page displays provinces', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('TEST PROVINCE')
        ->assertSee('Provinsi di Indonesia');
});

test('can view province detail page', function () {
    $response = $this->get("/wilayah/provinces/{$this->province->code}");

    $response->assertStatus(200)
        ->assertSee('TEST PROVINCE')
        ->assertSee('TEST REGENCY');
});

test('can view regency detail page', function () {
    $response = $this->get("/wilayah/regencies/{$this->regency->code}");

    $response->assertStatus(200)
        ->assertSee('TEST REGENCY')
        ->assertSee('TEST DISTRICT');
});

test('can view district detail page', function () {
    $response = $this->get("/wilayah/districts/{$this->district->code}");

    $response->assertStatus(200)
        ->assertSee('TEST DISTRICT')
        ->assertSee('TEST VILLAGE');
});

test('can view village detail page', function () {
    $response = $this->get("/wilayah/villages/{$this->village->code}");

    $response->assertStatus(200)
        ->assertSee('TEST VILLAGE')
        ->assertSee('TEST DISTRICT')
        ->assertSee('TEST REGENCY')
        ->assertSee('TEST PROVINCE');
});

test('can view islands page', function () {
    $response = $this->get('/wilayah/islands');

    $response->assertStatus(200)
        ->assertSee('Pulau-Pulau di Indonesia');
});

test('province detail shows statistics', function () {
    $response = $this->get("/wilayah/provinces/{$this->province->code}");

    $response->assertStatus(200)
        ->assertSee('1,000,000')
        ->assertSee('1,000.00');
});

test('breadcrumb navigation works', function () {
    $response = $this->get("/wilayah/regencies/{$this->regency->code}");

    $response->assertStatus(200)
        ->assertSee('Kembali ke')
        ->assertSee('TEST PROVINCE');
});
