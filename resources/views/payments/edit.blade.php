@extends('layout')

@section('title', 'Edit Payment')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-money-bill-wave"></i> Edit Payment</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="rental_id" class="form-label">Rental *</label>
                        <select class="form-select @error('rental_id') is-invalid @enderror" 
                                id="rental_id" name="rental_id" required>
                           @foreach($reservations as $reservation)
                                <option value="{{ $reservation->id }}" 
                                    {{ old('reservation_id', $payment->reservation_id) == $reservation->id ? 'selected' : '' }}>
                                    {{ $reservation->tenant->name }} - Room {{ $reservation->room->room_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('rental_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Payment Amount (₱) *</label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" 
                               value="{{ old('amount', $payment->amount) }}" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date *</label>
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                               id="payment_date" name="payment_date" 
                               value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="cash" {{ old('payment_method', $payment->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ old('payment_method', $payment->payment_method) === 'check' ? 'selected' : '' }}>Check</option>
                            <option value="online" {{ old('payment_method', $payment->payment_method) === 'online' ? 'selected' : '' }}>Online Payment</option>
                            <option value="other" {{ old('payment_method', $payment->payment_method) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="paid" {{ old('status', $payment->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status', $payment->status) === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reference_number" class="form-label">Reference Number (Optional)</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                               id="reference_number" name="reference_number" 
                               value="{{ old('reference_number', $payment->reference_number) }}">
                        @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Payment
                        </button>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Current Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Amount:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
                <p><strong>Date:</strong> {{ $payment->payment_date->format('M d, Y') }}</p>
                <p><strong>Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
                <p><strong>Status:</strong> 
                    @if($payment->status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning">Unpaid</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-trash"></i> Danger Zone</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Delete this payment record</p>
                <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Delete Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection