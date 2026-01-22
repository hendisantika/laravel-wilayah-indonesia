<?php

use App\Models\Province;
use App\Models\Regency;

beforeEach(function () {
    $this->province = Province::create([
        'code' => '99',
        'name' => 'TEST PROVINCE',
        'latitude' => -6.2,
        'longitude' => 106.8,
        'area' => 1000.00,
        'population' => 1000000,
    ]);

    $this->regency = Regency::create([
        'code' => '9901',
        'province_code' => '99',
        'name' => 'TEST REGENCY',
        'type' => 'kabupaten',
    ]);
});

test('can list all provinces', function () {
    $response = $this->getJson('/api/v1/provinces');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'code',
                    'name',
                    'latitude',
                    'longitude',
                    'area',
                    'population',
                ],
            ],
        ]);
});

test('can show single province', function () {
    $response = $this->getJson("/api/v1/provinces/{$this->province->code}");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'code' => '99',
                'name' => 'TEST PROVINCE',
            ],
        ]);
});

test('can show province with regencies', function () {
    $response = $this->getJson("/api/v1/provinces/{$this->province->code}?with_regencies=1");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'code',
                'name',
                'regencies' => [
                    '*' => ['code', 'name'],
                ],
            ],
        ]);
});

test('can create new province', function () {
    $data = [
        'code' => '98',
        'name' => 'NEW PROVINCE',
        'latitude' => -7.0,
        'longitude' => 107.0,
        'area' => 2000.00,
        'population' => 2000000,
    ];

    $response = $this->postJson('/api/v1/provinces', $data);

    $response->assertStatus(201)
        ->assertJson(['data' => ['code' => '98']]);

    $this->assertDatabaseHas('provinces', ['code' => '98']);
});

test('can update province', function () {
    $response = $this->putJson("/api/v1/provinces/{$this->province->code}", [
        'name' => 'UPDATED PROVINCE',
        'population' => 2000000,
    ]);

    $response->assertStatus(200)
        ->assertJson(['data' => ['name' => 'UPDATED PROVINCE']]);

    $this->assertDatabaseHas('provinces', [
        'code' => '99',
        'name' => 'UPDATED PROVINCE',
    ]);
});

test('can delete province', function () {
    $response = $this->deleteJson("/api/v1/provinces/{$this->province->code}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('provinces', ['code' => '99']);
});

test('cannot create province with duplicate code', function () {
    $data = [
        'code' => '99',
        'name' => 'DUPLICATE PROVINCE',
    ];

    $response = $this->postJson('/api/v1/provinces', $data);

    $response->assertStatus(422);
});

test('can search provinces by name', function () {
    $response = $this->getJson('/api/v1/provinces?search=TEST');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data');
});
