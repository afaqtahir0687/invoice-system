@extends('admin.layouts.app')

@section('title', 'Quotes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Quotes</h4>
    <a href="{{ route('quotes.create') }}" class="btn btn-primary">Create New Quote</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Quote #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                <tr>
                    <td>{{ $quote->quote_number }}</td>
                    <td>{{ $quote->customer->name }}</td>
                    <td>{{ $quote->quote_date }}</td>
                    <td>{{ format_currency($quote->grand_total) }}</td>
                    <td>
                        <span class="badge {{ $quote->status == 'Sent' ? 'bg-info' : ($quote->status == 'Accepted' ? 'bg-success' : ($quote->status == 'Invoiced' ? 'bg-primary' : 'bg-secondary')) }}">
                            {{ $quote->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('quotes.show', $quote) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-sm btn-outline-info">Edit</a>
                            <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                            @if($quote->status != 'Invoiced')
                            <a href="{{ route('quotes.convert', $quote) }}" class="btn btn-sm btn-outline-success" onclick="return confirm('Convert this quote to an Invoice?')">Convert</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $quotes->links() }}
    </div>
</div>
@endsection
