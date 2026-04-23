@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-home"></i> Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-door-open"></i></div>
            <div class="stat-label">Total Rooms</div>
            <div class="stat-value">{{ $totalRooms }}</div>
            <small class="text-muted">
                <i class="fas fa-check"></i> {{ $availableRooms }} Available
            </small>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-label">Total Tenants</div>
            <div class="stat-value">{{ $totalTenants }}</div>
            <small class="text-muted">
                <i class="fas fa-home"></i> {{ $activeReservations }} Active
            </small>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-contract"></i></div>
            <div class="stat-label">Active Reservations</div>
            <div class="stat-value">{{ $activeReservations }}</div>
            <small class="text-muted">Currently occupied rooms</small>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
            <small class="text-muted">All payments received</small>
        </div>
    </div>
</div>

<div class="row mt-4">

    <!-- RECENT RESERVATIONS -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-contract"></i> Recent Reservations
                </h5>
            </div>
            <div class="card-body">

                @if($recentReservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Tenant</th>
                                <th>Room</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReservations as $reservation)
                            <tr>
                                <td><strong>{{ $reservation->tenant->name }}</strong></td>
                                <td>Room {{ $reservation->room->room_number }}</td>
                                <td>
                                    @if($reservation->status === 'reserved')
                                        <span class="badge bg-warning">Reserved</span>
                                    @elseif($reservation->status === 'occupied' || $reservation->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Vacated</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center my-3">No reservations yet</p>
                @endif

            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list"></i> View All Reservations
                </a>
            </div>
        </div>
    </div>

    <!-- PENDING PAYMENTS -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Pending Payments
                </h5>
            </div>
            <div class="card-body">

                @if($pendingPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Tenant</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPayments as $payment)
                            <tr class="table-danger">
                                <td><strong>{{ $payment->reservation->tenant->name ?? 'N/A' }}</strong></td>
                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center my-3">No pending payments</p>
                @endif

            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list"></i> View All Payments
                </a>
            </div>
        </div>
    </div>
</div>

@endsection