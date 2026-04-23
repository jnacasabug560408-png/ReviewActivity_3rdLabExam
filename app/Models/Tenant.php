<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'identification_number',
    ];

    // FIXED: Tenant now uses Reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // FIXED: Payments go through Reservation
    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Reservation::class,
            'tenant_id',        // Foreign key on reservations table
            'reservation_id',   // Foreign key on payments table
            'id',
            'id'
        );
    }
}