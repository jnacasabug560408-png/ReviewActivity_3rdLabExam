@extends('layout')

@section('title', 'Add Payment')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-money-bill-wave"></i> Record Payment</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
            <li class="breadcrumb-item active">Add Payment</li>
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
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="rental_id" class="form-label">Select Rental *</label>
                        <select class="form-select @error('rental_id') is-invalid @enderror" 
                                id="rental_id" name="rental_id" required>
                            <option value="">-- Select a Rental --</option>
                           @foreach($reservations as $reservation)
                                <option value="{{ $rental->id }}" data-fee="{{ $rental->monthly_fee }}" 
                                    {{ old('rental_id') == $rental->id ? 'selected' : '' }}>
                                    {{ $rental->tenant->name }} - Room {{ $rental->room->room_number }} (₱{{ number_format($rental->monthly_fee, 2) }})
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
                               id="amount" name="amount" placeholder="e.g., 5000" 
                               value="{{ old('amount') }}" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date *</label>
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                               id="payment_date" name="payment_date" 
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="">-- Select Method --</option>
                            <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ old('payment_method') === 'check' ? 'selected' : '' }}>Check</option>
                            <option value="online" {{ old('payment_method') === 'online' ? 'selected' : '' }}>Online Payment</option>
                            <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Payment Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">-- Select Status --</option>
                            <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reference_number" class="form-label">Reference Number (Optional)</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                               id="reference_number" name="reference_number" placeholder="e.g., TXN-001, Check #123" 
                               value="{{ old('reference_number') }}">
                        @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Instructions</h5>
            </div>
            <div class="card-body">
                <p><strong>Rental:</strong> Select the rental record for this payment</p>
                <p><strong>Amount:</strong> The amount paid by the tenant</p>
                <p><strong>Date:</strong> When the payment was received</p>
                <p><strong>Method:</strong> How the payment was made</p>
                <p><strong>Status:</strong> Mark as Paid or Unpaid</p>
                <p><strong>Reference:</strong> Optional transaction or check number</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-dollar-sign"></i> Monthly Fee</h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted small mb-2">Selected rental monthly fee:</p>
                <h3 id="monthly_fee_display" class="text-success">₱0.00</h3>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('rental_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const fee = selectedOption.getAttribute('data-fee') || 0;
        document.getElementById('monthly_fee_display').textContent = '₱' + parseFloat(fee).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    });
    
    // Initialize on page load
    document.getElementById('rental_id').dispatchEvent(new Event('change'));
</script>
@endpush

@endsection