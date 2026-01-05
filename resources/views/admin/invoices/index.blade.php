@extends('admin.layouts.app')

@section('title', 'Manage Invoices')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Invoices</h2>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary-modern d-flex align-items-center">
        <i class="fas fa-plus me-2"></i> Create New Invoice
    </a>
</div>

<x-card :padding="false">
    <x-table>
        <x-slot name="thead">
            <th>Invoice #</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Grand Total</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Status</th>
            <th class="text-end">Action</th>
        </x-slot>

        @foreach($invoices as $invoice)
        <tr>
            <td class="fw-bold text-primary">{{ $invoice->invoice_number }}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm me-2 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                        {{ strtoupper(substr($invoice->customer->name, 0, 1)) }}
                    </div>
                    {{ $invoice->customer->name }}
                </div>
            </td>
            <td class="text-muted">{{ $invoice->invoice_date }}</td>
            <td class="fw-semibold text-dark">{{ format_currency($invoice->grand_total) }}</td>
            <td class="text-success fw-medium">{{ format_currency($invoice->amount_paid) }}</td>
            <td class="text-danger fw-medium">{{ format_currency($invoice->balance_due) }}</td>
            <td>
                @php
                    $statusClass = match($invoice->status) {
                        'Paid' => 'badge-soft-success',
                        'Partially Paid' => 'badge-soft-info',
                        'Unpaid' => 'badge-soft-danger',
                        default => 'badge-soft-warning'
                    };
                @endphp
                <span class="badge-soft {{ $statusClass }}">
                    {{ $invoice->status }}
                </span>
            </td>
            <td class="text-end">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle shadow-none" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item py-2" href="{{ route('invoices.show', $invoice) }}"><i class="fas fa-eye me-2 text-primary"></i> View Detail</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('invoices.edit', $invoice) }}"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('invoices.pdf', $invoice) }}"><i class="fas fa-file-pdf me-2 text-danger"></i> Download PDF</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </x-table>
    
    @if($invoices->hasPages())
        <div class="card-footer bg-transparent border-top p-4">
            {{ $invoices->links() }}
        </div>
    @endif
</x-card>
@endsection
