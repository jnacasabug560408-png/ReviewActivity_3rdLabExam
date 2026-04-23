@extends('layout')

@section('title', 'Payments')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-money-bill-wave"></i> Payment Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Payment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Payments</h5>
    </div>
    <div class="card-body">
        @if($payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="25%">Tenant</th>
                        <th width="15%">Amount</th>
                        <th width="15%">Payment Date</th>
                        <th width="15%">Method</th>
                        <th width="12%">Status</th>
                        <th width="18%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <!-- UPDATED: rental -> reservation -->
                        <td>
                            <strong>
                                {{ $payment->reservation->tenant->name ?? 'N/A' }}
                            </strong>
                        </td>

                        <td>
                            <span class="badge bg-info">
                                ₱{{ number_format($payment->amount, 2) }}
                            </span>
                        </td>

                        <td>
                            {{ $payment->payment_date->format('M d, Y') }}
                        </td>

                        <td>
                            {{ ucfirst($payment->payment_method) }}
                        </td>

                        <td>
                            @if($payment->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Unpaid</span>
                            @endif
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $payments->links() }}
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No payments found.
            <a href="{{ route('payments.create') }}">Add one now!</a>
        </div>
        @endif
    </div>
</div>
@endsection