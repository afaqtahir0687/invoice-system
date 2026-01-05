@extends('admin.layouts.app')

@section('title', 'Manage Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Customers</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-primary-modern d-flex align-items-center">
        <i class="fas fa-plus me-2"></i> Add New Customer
    </a>
</div>

<x-card :padding="false">
    <x-table>
        <x-slot name="thead">
            <th>Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th class="text-end pe-4">Action</th>
        </x-slot>

        @foreach($customers as $customer)
        <tr class="align-middle">
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $customer->name }}</div>
                        <div class="text-muted small">ID: #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </td>
            <td class="text-muted">{{ $customer->company_name ?: '---' }}</td>
            <td><a href="mailto:{{ $customer->email }}" class="text-decoration-none">{{ $customer->email }}</a></td>
            <td class="text-muted">{{ $customer->phone }}</td>
            <td>
                <span class="badge-soft {{ $customer->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                    {{ $customer->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td class="text-end pe-4">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item py-2" href="{{ route('customers.edit', $customer) }}"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item py-2 text-danger" onclick="return confirm('Are you sure you want to delete this customer?')">
                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </x-table>
    
    @if($customers->hasPages())
        <div class="card-footer bg-transparent border-top p-4">
            {{ $customers->links() }}
        </div>
    @endif
</x-card>
@endsection
