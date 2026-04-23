@extends('layout')

@section('title', 'Tenants')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1><i class="fas fa-users"></i> Tenant Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tenants</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('tenants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Tenant
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Tenants</h5>
    </div>
    <div class="card-body">
        @if($tenants->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="20%">Name</th>
                        <th width="20%">Email</th>
                        <th width="15%">Phone</th>
                        <th width="25%">Address</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                    <tr>
                        <td><strong>{{ $tenant->name }}</strong></td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->phone }}</td>
                        <td>{{ Str::limit($tenant->address, 40) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
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
            <i class="fas fa-info-circle"></i> No tenants found. <a href="{{ route('tenants.create') }}">Add one now!</a>
        </div>
        @endif
    </div>
</div>
@endsection