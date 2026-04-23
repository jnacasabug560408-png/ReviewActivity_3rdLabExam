<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'monthly_fee',
        'capacity',
        'is_available',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'capacity' => 'integer',
        'is_available' => 'boolean',
    ];

    // FIXED: use Reservation instead of Rental
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getAvailabilityLabel()
    {
        return $this->is_available ? 'Available' : 'Occupied';
    }
}