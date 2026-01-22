<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regency extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'province_code',
        'name',
        'type',
        'latitude',
        'longitude',
        'elevation',
        'timezone',
        'area',
        'population',
        'boundaries',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'elevation' => 'decimal:2',
        'area' => 'decimal:2',
        'population' => 'integer',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'regency_code', 'code');
    }

    public function islands(): HasMany
    {
        return $this->hasMany(Island::class, 'regency_code', 'code');
    }
}
