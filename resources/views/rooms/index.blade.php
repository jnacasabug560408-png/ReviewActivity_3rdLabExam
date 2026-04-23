@extends('layout')

@section('title', 'Rooms')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-door-open"></i> Room Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Room
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Rooms</h5>
    </div>
    <div class="card-body">
        @if($rooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="15%">Room Number</th>
                        <th width="20%">Monthly Fee</th>
                        <th width="15%">Capacity</th>
                        <th width="20%">Status</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td>
                            <strong>{{ $room->room_number }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-success">₱{{ number_format($room->monthly_fee, 2) }}</span>
                        </td>
                        <td>
                            <i class="fas fa-users"></i> {{ $room->capacity }} person(s)
                        </td>
                        <td>
                            @if($room->availability_status === 'available')
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Occupied</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No rooms found. <a href="{{ route('rooms.create') }}">Create one now!</a>
        </div>
        @endif
    </div>
</div>
@endsection