<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $payments = Payment::with('reservation.tenant')
            ->latest()
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $reservations = Reservation::where('status', '!=', 'vacated')
            ->with('tenant', 'room')
            ->get();

        return view('payments.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load('reservation.tenant', 'reservation.room');

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $reservations = Reservation::with('tenant', 'room')->get();

        return view('payments.edit', compact('payment', 'reservations'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }

    public function createForReservation(Reservation $reservation)
    {
        return view('payments.create-for-reservation', compact('reservation'));
    }
}