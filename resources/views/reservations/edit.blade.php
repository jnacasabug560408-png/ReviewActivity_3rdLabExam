@extends('layout')

@section('title', 'Edit Reservation')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-file-contract"></i> Edit Reservation</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservations</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
                <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tenant_id" class="form-label">Tenant *</label>
                        <select class="form-select @error('tenant_id') is-invalid @enderror" 
                                id="tenant_id" name="tenant_id" required>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" 
                                    {{ old('tenant_id', $reservation->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tenant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Room *</label>
                        <select class="form-select @error('room_id') is-invalid @enderror" 
                                id="room_id" name="room_id" required>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" 
                                    {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                    Room {{ $room->room_number }} - ₱{{ number_format($room->monthly_fee, 2) }}
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
                               value="{{ old('move_in_date', $reservation->move_in_date->format('Y-m-d')) }}" required>
                        @error('move_in_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="move_out_date" class="form-label">Move-out Date (Optional)</label>
                        <input type="date" class="form-control @error('move_out_date') is-invalid @enderror" 
                               id="move_out_date" name="move_out_date" 
                               value="{{ old('move_out_date', $reservation->move_out_date?->format('Y-m-d')) }}">
                        @error('move_out_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="reserved" {{ old('status', $reservation->status) === 'reserved' ? 'selected' : '' }}>
                                Reserved
                            </option>
                            <option value="active" {{ old('status', $reservation->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="vacated" {{ old('status', $reservation->status) === 'vacated' ? 'selected' : '' }}>
                                Vacated
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Reservation
                        </button>
                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-secondary">
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
                <p><strong>Tenant:</strong> {{ $reservation->tenant->name }}</p>
                <p><strong>Room:</strong> {{ $reservation->room->room_number }}</p>
                <p><strong>Moved-in:</strong> {{ $reservation->move_in_date->format('M d, Y') }}</p>
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