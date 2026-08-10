<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingLane extends Model
{
    protected $fillable = [
        'origin',
        'destination',
        'distance_km',
        'price',
        'is_firm',
        'is_active',
    ];

    protected $casts = [
        'distance_km' => 'integer',
        'price' => 'decimal:2',
        'is_firm' => 'boolean',
        'is_active' => 'boolean',
    ];
}