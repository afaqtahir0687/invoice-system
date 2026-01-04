@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Customers</h4>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $customer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-info">Edit</a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $customers->links() }}
    </div>
</div>
@endsection
