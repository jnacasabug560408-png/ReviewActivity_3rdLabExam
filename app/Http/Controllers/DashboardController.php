<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        // Room Statistics
        $totalRooms = Room::count();
        $availableRooms = Room::where('is_available', true)->count();
        $occupiedRooms = Room::where('is_available', false)->count();
        
        // Tenant Statistics
        $totalTenants = Tenant::count();

        // Reservation Statistics
        $activeReservations = Reservation::where('status', 'active')->count();

        // Revenue
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        
        // Recent Reservations
        $recentReservations = Reservation::with(['tenant', 'room'])
            ->latest()
            ->take(5)
            ->get();
        
        // Pending Payments (FIXED)
        $pendingPayments = Payment::where('status', 'unpaid')
            ->with('reservation.tenant')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'totalTenants',
            'activeReservations',
            'totalRevenue',
            'recentReservations',
            'pendingPayments'
        ));
    }
}