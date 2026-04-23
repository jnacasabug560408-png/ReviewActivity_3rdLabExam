@extends('layout')

@section('title', 'Reservation Details')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-file-contract"></i> Reservation Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>

        <div class="btn-group">
            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('payments.create', ['reservation' => $reservation]) }}" class="btn btn-success">
                <i class="fas fa-money-bill"></i> Add Payment
            </a>

            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Tenant Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $reservation->tenant->name }}</p>
                <p><strong>Email:</strong> {{ $reservation->tenant->email }}</p>
                <p><strong>Phone:</strong> {{ $reservation->tenant->phone }}</p>
                <p><strong>Address:</strong> {{ $reservation->tenant->address }}</p>
                <p><strong>ID Number:</strong> {{ $reservation->tenant->identification_number }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Room Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Room:</strong> {{ $reservation->room->room_number }}</p>
                <p><strong>Monthly Fee:</strong> ₱{{ number_format($reservation->room->monthly_fee, 2) }}</p>
                <p><strong>Capacity:</strong> {{ $reservation->room->capacity }}</p>
                <p>
                    <strong>Status:</strong>
                    @if($reservation->room->is_available)
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-danger">Occupied</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Reservation Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Move-in Date:</strong> {{ $reservation->move_in_date->format('M d, Y') }}</p>

                @if($reservation->move_out_date)
                    <p><strong>Move-out Date:</strong> {{ $reservation->move_out_date->format('M d, Y') }}</p>
                @endif

                <p><strong>Status:</strong>
                    @if($reservation->status === 'reserved')
                        <span class="badge bg-warning">Reserved</span>
                    @elseif($reservation->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Vacated</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@endsection