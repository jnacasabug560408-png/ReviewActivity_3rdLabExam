@extends('layout')

@section('title', 'Edit Room')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-door-open"></i> Edit Room {{ $room->room_number }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Rooms</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Room Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rooms.update', $room) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number *</label>
                        <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                               id="room_number" name="room_number" 
                               value="{{ old('room_number', $room->room_number) }}" required>
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="monthly_fee" class="form-label">Monthly Rental Fee (₱) *</label>
                        <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror" 
                               id="monthly_fee" name="monthly_fee" 
                               value="{{ old('monthly_fee', $room->monthly_fee) }}" required>
                        @error('monthly_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity (Number of Persons) *</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" name="capacity" 
                               value="{{ old('capacity', $room->capacity) }}" min="1" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="availability_status" class="form-label">Availability Status *</label>
                        <select class="form-select @error('availability_status') is-invalid @enderror" 
                                id="availability_status" name="availability_status" required>
                            <option value="available" {{ old('availability_status', $room->availability_status) === 'available' ? 'selected' : '' }}>
                                Available
                            </option>
                            <option value="occupied" {{ old('availability_status', $room->availability_status) === 'occupied' ? 'selected' : '' }}>
                                Occupied
                            </option>
                        </select>
                        @error('availability_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Room
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Room Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Created:</strong> {{ $room->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated:</strong> {{ $room->updated_at->format('M d, Y H:i') }}</p>
                <hr>
                <p><strong>Active Reservations:</strong> {{ $room->reservations()->where('status', '!=', 'vacated')->count() }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-trash"></i> Danger Zone</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Delete this room permanently</p>
                <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Delete Room
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection