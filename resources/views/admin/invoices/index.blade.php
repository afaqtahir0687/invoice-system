@extends('admin.layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Invoices</h4>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create New Invoice</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Grand Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ format_currency($invoice->grand_total) }}</td>
                    <td class="text-success">{{ format_currency($invoice->amount_paid) }}</td>
                    <td class="text-danger">{{ format_currency($invoice->balance_due) }}</td>
                    <td>
                        <span class="badge {{ $invoice->status == 'Paid' ? 'bg-success' : ($invoice->status == 'Partially Paid' ? 'bg-info' : 'bg-warning') }}">
                            {{ $invoice->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-info">Edit</a>
                            <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
