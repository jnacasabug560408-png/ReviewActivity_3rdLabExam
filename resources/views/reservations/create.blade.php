@extends('layout')

@section('title', 'Create Rental')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-file-contract"></i> Create New Reservation</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Reservation Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tenant_id" class="form-label">Select Tenant *</label>
                        <select class="form-select @error('tenant_id') is-invalid @enderror" 
                                id="tenant_id" name="tenant_id" required>
                            <option value="">-- Select a Tenant --</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }} ({{ $tenant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('tenant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Select Room *</label>
                        <select class="form-select @error('room_id') is-invalid @enderror" 
                                id="room_id" name="room_id" required>
                            <option value="">-- Select a Room --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" data-fee="{{ $room->monthly_fee }}" 
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    Room {{ $room->room_number }} - ₱{{ number_format($room->monthly_fee, 2) }} (Capacity: {{ $room->capacity }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="move_in_date" class="form-label">Move-in Date *</label>
                        <input type="date" class="form-control @error('move_in_date') is-invalid @enderror" 
                               id="move_in_date" name="move_in_date" 
                               value="{{ old('move_in_date') }}" required>
                        @error('move_in_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Rental Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">-- Select Status --</option>
                            <option value="reserved" {{ old('status') === 'reserved' ? 'selected' : '' }}>
                                Reserved (Not yet occupied)
                            </option>
                            <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>
                                Occupied (Currently living)
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Monthly Fee:</strong> <span id="monthly_fee_display">₱0.00</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create Rental
                        </button>
                        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">
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
                <p><strong>Tenant:</strong> Select an existing tenant from the list</p>
                <p><strong>Room:</strong> Select an available room. Only available rooms are shown</p>
                <p><strong>Move-in Date:</strong> The date the tenant will start occupying the room</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-warning">Reserved</span> = Booking, not yet moved in
                    <span class="badge bg-success">Occupied</span> = Tenant is living in the room
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('room_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const fee = selectedOption.getAttribute('data-fee') || 0;
        document.getElementById('monthly_fee_display').textContent = '₱' + parseFloat(fee).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    });
    
    // Initialize on page load
    document.getElementById('room_id').dispatchEvent(new Event('change'));
</script>
@endpush

@endsection