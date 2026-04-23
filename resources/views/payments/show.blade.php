@extends('layout')

@section('title', 'Payment Details')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-receipt"></i> Payment Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
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
                <h5 class="mb-0"><i class="fas fa-user"></i> Tenant Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="fw-bold">Name:</td>
                        <td>{{ $payment->rental->tenant->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email:</td>
                        <td><a href="mailto:{{ $payment->rental->tenant->email }}">{{ $payment->rental->tenant->email }}</a></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone:</td>
                        <td><a href="tel:{{ $payment->rental->tenant->phone }}">{{ $payment->rental->tenant->phone }}</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-door-open"></i> Room Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="fw-bold">Room:</td>
                        <td><strong>Room {{ $payment->rental->room->room_number }}</strong></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Monthly Fee:</td>
                        <td><span class="badge bg-success">₱{{ number_format($payment->rental->monthly_fee, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Rental Status:</td>
                        <td>
                            @if($payment->rental->status === 'occupied')
                                <span class="badge bg-success">Occupied</span>
                            @elseif($payment->rental->status === 'reserved')
                                <span class="badge bg-warning">Reserved</span>
                            @else
                                <span class="badge bg-secondary">Vacated</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Payment Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <p class="text-muted small">Payment Amount</p>
                            <h2 class="text-success">₱{{ number_format($payment->amount, 2) }}</h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <p class="text-muted small">Payment Date</p>
                            <h4>{{ $payment->payment_date->format('M d, Y') }}</h4>
                            <small class="text-muted">{{ $payment->payment_date->format('l') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <p class="text-muted small">Payment Method</p>
                            <h5>
                                @if($payment->payment_method === 'cash')
                                    <i class="fas fa-money-bill"></i> Cash
                                @elseif($payment->payment_method === 'bank_transfer')
                                    <i class="fas fa-bank"></i> Bank Transfer
                                @elseif($payment->payment_method === 'check')
                                    <i class="fas fa-receipt"></i> Check
                                @elseif($payment->payment_method === 'online')
                                    <i class="fas fa-globe"></i> Online
                                @else
                                    {{ ucfirst($payment->payment_method) }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <p class="text-muted small">Status</p>
                            @if($payment->status === 'paid')
                                <h4><span class="badge bg-success">PAID</span></h4>
                            @else
                                <h4><span class="badge bg-warning">UNPAID</span></h4>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Reference Number:</strong></p>
                        <p>{{ $payment->reference_number ?? '<span class="text-muted">-</span>' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Recorded:</strong></p>
                        <p>{{ $payment->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-link"></i> Related Information</h5>
    </div>
    <div class="card-body">
        <p>
            <strong>Rental Record:</strong> 
           <a href="{{ route('reservations.show', $payment->reservation) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-file-contract"></i> View Full Rental Details
            </a>
        </p>
    </div>
</div>
@endsection