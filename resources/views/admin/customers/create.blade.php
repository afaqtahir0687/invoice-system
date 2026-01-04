@extends('admin.layouts.app')

@section('title', isset($customer) ? 'Edit Customer' : 'Add Customer')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5>{{ isset($customer) ? 'Edit Customer' : 'Add Customer' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($customer) ? route('customers.update', $customer) : route('customers.store') }}" method="POST">
            @csrf
            @if(isset($customer)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name ?? '') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $customer->company_name ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone ?? '') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $customer->address ?? '') }}</textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $customer->city ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ZIP Code</label>
                    <input type="text" name="zip" class="form-control" value="{{ old('zip', $customer->zip ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $customer->country ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tax ID</label>
                    <input type="text" name="tax_id" class="form-control" value="{{ old('tax_id', $customer->tax_id ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $customer->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $customer->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Update' : 'Save' }} Customer</button>
            </div>
        </form>
    </div>
</div>
@endsection
