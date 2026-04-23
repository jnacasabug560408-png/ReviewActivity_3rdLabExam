<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations.
     */
    public function index()
    {
        $reservations = Reservation::with('tenant', 'room')
            ->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $tenants = Tenant::where('status', 'active')->get();
        $availableRooms = Room::where('status', 'available')->get();
        
        return view('reservations.create', compact('tenants', 'availableRooms'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date|after:today',
            'status' => 'required|in:reserved,occupied,vacated',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if room is available
        $room = Room::find($validated['room_id']);
        if ($room->status !== 'available') {
            return back()->with('error', 'Selected room is not available!');
        }

        // Create reservation
        Reservation::create($validated);

        // Update room status if occupation
        if ($validated['status'] === 'occupied') {
            $room->update(['status' => 'occupied']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created successfully!');
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('tenant', 'room');
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(Reservation $reservation)
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
        return view('reservations.edit', compact('reservation', 'tenants', 'rooms'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date',
            'move_out_date' => 'nullable|date|after:move_in_date',
            'status' => 'required|in:reserved,occupied,vacated',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldRoom = $reservation->room;
        
        $reservation->update($validated);

        // Update room statuses
        if ($oldRoom->id !== $validated['room_id']) {
            // Release old room if no other active reservations
            if (!$oldRoom->reservations()->where('status', 'occupied')->exists()) {
                $oldRoom->update(['status' => 'available']);
            }
        }

        // Update new room status
        $newRoom = Room::find($validated['room_id']);
        if ($validated['status'] === 'occupied') {
            $newRoom->update(['status' => 'occupied']);
        } elseif ($validated['status'] === 'vacated') {
            $newRoom->update(['status' => 'available']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation updated successfully!');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $room = $reservation->room;
        
        $reservation->delete();

        // Update room status
        if (!$room->reservations()->where('status', 'occupied')->exists()) {
            $room->update(['status' => 'available']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully!');
    }
}