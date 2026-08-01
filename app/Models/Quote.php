<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'ref',
        'name',
        'company',
        'phone',
        'email',
        'origin',
        'destination',
        'truck_type',
        'cargo_type',
        'weight_band',
        'truck_count',
        'load_date',
        'readiness',
        'notes',
        'subtotal',
        'vat',
        'total',
        'price_source',
        'status',
    ];
}