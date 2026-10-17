<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'registration_no',
        'make',
        'manufacture_year',
        'type',
        'fuel_type',
        'color',
        'purchased_date',
        'purchased_price',
        'insurance_expire_date',
        'road_tax_expire_date',
        'current_odo_reading',
        'engine_condition_percentage',
        'body_condition_percentage',
        'current_location',
        'parking_location',
    ];

    protected function casts(): array
    {
        return [
            'manufacture_year' => 'integer',
            'purchased_date' => 'date',
            'purchased_price' => 'decimal:2',
            'insurance_expire_date' => 'date',
            'road_tax_expire_date' => 'date',
            'current_odo_reading' => 'decimal:2',
            'engine_condition_percentage' => 'integer',
            'body_condition_percentage' => 'integer',
        ];
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(VehicleChangeRequest::class);
    }
}
