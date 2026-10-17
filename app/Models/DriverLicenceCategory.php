<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverLicenceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'licence_category',
        'expiry_date',
        'receive_date',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'receive_date' => 'date',
        ];
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}