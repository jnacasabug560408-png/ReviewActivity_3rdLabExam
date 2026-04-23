@extends('layout')

@section('title', 'Add New Room')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-door-open"></i> Add New Room</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Rooms</a></li>
            <li class="breadcrumb-item active">Add New</li>
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
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number *</label>
                        <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                               id="room_number" name="room_number" placeholder="e.g., 101, A-01" 
                               value="{{ old('room_number') }}" required>
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="monthly_fee" class="form-label">Monthly Rental Fee (₱) *</label>
                        <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror" 
                               id="monthly_fee" name="monthly_fee" placeholder="e.g., 5000" 
                               value="{{ old('monthly_fee') }}" required>
                        @error('monthly_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity (Number of Persons) *</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" name="capacity" placeholder="e.g., 2" 
                               value="{{ old('capacity') }}" min="1" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="availability_status" class="form-label">Availability Status *</label>
                        <select class="form-select @error('availability_status') is-invalid @enderror" 
                                id="availability_status" name="availability_status" required>
                            <option value="">-- Select Status --</option>
                            <option value="available" {{ old('availability_status') === 'available' ? 'selected' : '' }}>
                                <i class="fas fa-check"></i> Available
                            </option>
                            <option value="occupied" {{ old('availability_status') === 'occupied' ? 'selected' : '' }}>
                                <i class="fas fa-ban"></i> Occupied
                            </option>
                        </select>
                        @error('availability_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Room
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
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Instructions</h5>
            </div>
            <div class="card-body">
                <p><strong>Room Number:</strong> Unique identifier for the room (e.g., 101, A-01, Room 1)</p>
                <p><strong>Monthly Fee:</strong> Amount tenant pays per month in Philippine Pesos (₱)</p>
                <p><strong>Capacity:</strong> Maximum number of persons allowed in the room</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-success">Available</span> = Ready for rent
                    <span class="badge bg-danger">Occupied</span> = Currently rented
                </p>
            </div>
        </div>
    </div>
</div>
@endsection