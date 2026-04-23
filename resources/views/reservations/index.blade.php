@extends('layout')

@section('title', 'Reservations')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-file-contract"></i> Reservation Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reservations</li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Reservation
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Reservations</h5>
    </div>

    <div class="card-body">
        @if($reservations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="20%">Tenant</th>
                        <th width="15%">Room</th>
                        <th width="15%">Move-in Date</th>
                        <th width="12%">Status</th>
                        <th width="15%">Monthly Fee</th>
                        <th width="23%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td><strong>{{ $reservation->tenant->name }}</strong></td>
                        <td>Room {{ $reservation->room->room_number }}</td>
                        <td>{{ $reservation->move_in_date->format('M d, Y') }}</td>

                        <td>
                            @if($reservation->status === 'reserved')
                                <span class="badge bg-warning">Reserved</span>
                            @elseif($reservation->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Vacated</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-info">
                                ₱{{ number_format($reservation->room->monthly_fee, 2) }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <a href="{{ route('payments.create', ['reservation' => $reservation]) }}" class="btn btn-outline-success">
                                    <i class="fas fa-money-bill"></i> Payment
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $reservations->links() }}
        </div>

        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No reservations found.
            <a href="{{ route('reservations.create') }}">Create one now!</a>
        </div>
        @endif
    </div>
</div>
@endsection