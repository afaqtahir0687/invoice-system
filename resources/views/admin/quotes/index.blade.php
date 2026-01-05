@extends('admin.layouts.app')

@section('title', 'Manage Quotes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Quotes</h2>
    <a href="{{ route('quotes.create') }}" class="btn btn-primary-modern d-flex align-items-center">
        <i class="fas fa-plus me-2"></i> Create New Quote
    </a>
</div>

<x-card :padding="false">
    <x-table>
        <x-slot name="thead">
            <th>Quote #</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Grand Total</th>
            <th>Status</th>
            <th>Images</th>
            <th class="text-end">Action</th>
        </x-slot>

        @foreach($quotes as $quote)
        <tr>
            <td class="fw-bold text-primary">{{ $quote->quote_number }}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm me-2 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                        {{ strtoupper(substr($quote->customer->name, 0, 1)) }}
                    </div>
                    {{ $quote->customer->name }}
                </div>
            </td>
            <td class="text-muted">{{ $quote->quote_date }}</td>
            <td class="fw-semibold text-dark">{{ format_currency($quote->grand_total) }}</td>
            <td>
                @php
                    $statusClass = match($quote->status) {
                        'Accepted' => 'badge-soft-success',
                        'Sent' => 'badge-soft-info',
                        'Invoiced' => 'badge-soft-primary',
                        'Declined' => 'badge-soft-danger',
                        default => 'badge-soft-warning'
                    };
                @endphp
                <span class="badge-soft {{ $statusClass }}">
                    {{ $quote->status }}
                </span>
            </td>
            <td>
                @if($quote->images && count($quote->images) > 0)
                    <div class="d-flex align-items-center gap-1">
                        @foreach($quote->images as $index => $image)
                            @if($index < 3)
                            <img src="{{ asset($image) }}" 
                                 class="rounded-2 border" 
                                 style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;" 
                                 data-bs-toggle="tooltip" 
                                 title="Click to view quote"
                                 onclick="window.location.href='{{ route('quotes.show', $quote) }}'">
                            @endif
                        @endforeach
                        @if(count($quote->images) > 3)
                            <span class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                  style="width: 40px; height: 40px; font-size: 0.75rem; cursor: pointer;"
                                  onclick="window.location.href='{{ route('quotes.show', $quote) }}'">
                                +{{ count($quote->images) - 3 }}
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-muted small">
                        <i class="fas fa-image me-1"></i>No images
                    </span>
                @endif
            </td>
            <td class="text-end">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle shadow-none" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item py-2" href="{{ route('quotes.show', $quote) }}"><i class="fas fa-eye me-2 text-primary"></i> View Detail</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('quotes.edit', $quote) }}"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('quotes.pdf', $quote) }}"><i class="fas fa-file-pdf me-2 text-danger"></i> Download PDF</a></li>
                        @if($quote->status != 'Invoiced')
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-success" href="{{ route('quotes.convert', $quote) }}" onclick="return confirm('Convert this quote to an Invoice?')"><i class="fas fa-exchange-alt me-2"></i> Convert to Invoice</a></li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </x-table>
    
    @if($quotes->hasPages())
        <div class="card-footer bg-transparent border-top p-4">
            {{ $quotes->links() }}
        </div>
    @endif
</x-card>
@endsection
