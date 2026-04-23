<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'move_in_date',
        'move_out_date',
        'status',
        'notes',
    ];

    protected $dates = [
        'move_in_date',
        'move_out_date',
    ];

    /**
     * Get the tenant for the reservation.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the room for the reservation.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the payments for this reservation
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Room::class, 'id', 'room_id', 'room_id', 'id');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'reserved' => 'warning',
            'occupied' => 'success',
            'vacated' => 'secondary',
            default => 'primary',
        };
    }

    /**
     * Calculate days occupied
     */
    public function getDaysOccupiedAttribute()
    {
        $endDate = $this->move_out_date ?? now();
        return $this->move_in_date->diffInDays($endDate);
    }
}