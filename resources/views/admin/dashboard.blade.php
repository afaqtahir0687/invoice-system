@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Total Customers</h6>
                        <h3 class="mb-0">{{ $stats['customers_count'] }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Total Invoices</h6>
                        <h3 class="mb-0">{{ $stats['invoices_count'] }}</h3>
                    </div>
                    <i class="fas fa-file-invoice-dollar fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Paid Amount</h6>
                        <h3 class="mb-0">{{ format_currency($stats['total_paid']) }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Pending Amount</h6>
                        <h3 class="mb-0">{{ format_currency($stats['total_pending']) }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Invoices</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentInvoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ format_currency($invoice->grand_total) }}</td>
                            <td>
                                <span class="badge {{ $invoice->status == 'Paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-link text-decoration-none">View All Invoices</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('quotes.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-file-invoice me-2"></i> Create New Quote
                    </a>
                    <a href="{{ route('invoices.create') }}" class="btn btn-outline-success text-start">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Create New Invoice
                    </a>
                    <a href="{{ route('customers.create') }}" class="btn btn-outline-info text-start">
                        <i class="fas fa-user-plus me-2"></i> Add New Customer
                    </a>
                    <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary text-start">
                        <i class="fas fa-cog me-2"></i> System Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
