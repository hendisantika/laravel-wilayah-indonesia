<?php

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

beforeEach(function () {
    $this->province = Province::create([
        'code' => '99',
        'name' => 'TEST PROVINCE',
    ]);

    $this->regency = Regency::create([
        'code' => '9901',
        'province_code' => '99',
        'name' => 'TEST REGENCY',
        'type' => 'kabupaten',
        'population' => 500000,
    ]);

    $this->district = District::create([
        'code' => '990101',
        'regency_code' => '9901',
        'name' => 'TEST DISTRICT',
    ]);
});

test('can list all regencies', function () {
    $response = $this->getJson('/api/v1/regencies');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'province_code',
                    'name',
                    'type',
                ],
            ],
        ]);
});

test('can filter regencies by province', function () {
    $response = $this->getJson('/api/v1/regencies?province_code=99');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data');
});

test('can filter regencies by type', function () {
    $response = $this->getJson('/api/v1/regencies?type=kabupaten');

    $response->assertStatus(200);

    $regencies = $response->json('data');
    foreach ($regencies as $regency) {
        expect($regency['type'])->toBe('kabupaten');
    }
});

test('can show regency with relationships', function () {
    $response = $this->getJson("/api/v1/regencies/{$this->regency->code}?with_province=1&with_districts=1");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'code',
                'name',
                'province' => ['code', 'name'],
                'districts',
            ],
        ]);
});

test('can create new regency', function () {
    $data = [
        'code' => '9902',
        'province_code' => '99',
        'name' => 'NEW REGENCY',
        'type' => 'kota',
    ];

    $response = $this->postJson('/api/v1/regencies', $data);

    $response->assertStatus(201)
        ->assertJson(['data' => ['code' => '9902']]);

    $this->assertDatabaseHas('regencies', ['code' => '9902']);
});

test('can update regency', function () {
    $response = $this->putJson("/api/v1/regencies/{$this->regency->code}", [
        'name' => 'UPDATED REGENCY',
        'type' => 'kota',
    ]);

    $response->assertStatus(200)
        ->assertJson(['data' => ['name' => 'UPDATED REGENCY', 'type' => 'kota']]);
});

test('can delete regency', function () {
    $response = $this->deleteJson("/api/v1/regencies/{$this->regency->code}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('regencies', ['code' => '9901']);
});

test('regency must belong to existing province', function () {
    $data = [
        'code' => '9903',
        'province_code' => '00',
        'name' => 'INVALID REGENCY',
        'type' => 'kabupaten',
    ];

    $response = $this->postJson('/api/v1/regencies', $data);

    $response->assertStatus(422);
});
