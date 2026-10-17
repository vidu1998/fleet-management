<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'joined_date',
        'licence_file_path',
        'phone',
        'email',
        'drive_mileage',
        'blood_group',
        'is_smoker',
        'is_drinker',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'joined_date' => 'date',
            'drive_mileage' => 'decimal:2',
            'is_smoker' => 'boolean',
            'is_drinker' => 'boolean',
        ];
    }

    public function licenceCategories(): HasMany
    {
        return $this->hasMany(DriverLicenceCategory::class);
    }

    public function acknowledgements(): HasMany
    {
        return $this->hasMany(DriverAcknowledgement::class);
    }
}
