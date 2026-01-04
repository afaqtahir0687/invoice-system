@extends('admin.layouts.app')

@section('title', 'Quote ' . $quote->quote_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Quote Details: {{ $quote->quote_number }}</h4>
    <div>
        <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
        <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        @if($quote->status != 'Invoiced')
        <a href="{{ route('quotes.convert', $quote) }}" class="btn btn-success">
            <i class="fas fa-exchange-alt me-1"></i> Convert to Invoice
        </a>
        @endif
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-5">
        <div class="row mb-5">
            <div class="col-sm-6">
                <h6 class="mb-3 text-muted">From:</h6>
                @php $setting = \App\Models\Setting::first(); @endphp
                <div>
                    <strong>{{ $setting->company_name ?? 'My Company' }}</strong>
                </div>
                <div>{{ $setting->company_address ?? 'Address not set' }}</div>
                <div>Email: {{ $setting->company_email ?? 'email@example.com' }}</div>
                <div>Phone: {{ $setting->company_phone ?? '+00 000 0000' }}</div>
                @if($setting->company_tax_id)
                    <div>Tax ID: {{ $setting->company_tax_id }}</div>
                @endif
            </div>

            <div class="col-sm-6 text-sm-end">
                <h6 class="mb-3 text-muted">To:</h6>
                <div>
                    <strong>{{ $quote->customer->name }}</strong>
                </div>
                @if($quote->customer->company_name)
                    <div>{{ $quote->customer->company_name }}</div>
                @endif
                <div>{{ $quote->customer->address }}</div>
                <div>{{ $quote->customer->city }}, {{ $quote->customer->zip }}</div>
                <div>{{ $quote->customer->country }}</div>
                <div>Email: {{ $quote->customer->email }}</div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-4">
                <div class="text-muted mb-1">Quote Date</div>
                <div class="fw-bold">{{ $quote->quote_date }}</div>
            </div>
            <div class="col-sm-4">
                <div class="text-muted mb-1">Due Date</div>
                <div class="fw-bold">{{ $quote->due_date ?? 'N/A' }}</div>
            </div>
            <div class="col-sm-4 text-sm-end">
                <div class="text-muted mb-1">Reference</div>
                <div class="fw-bold">{{ $quote->reference ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead class="bg-light">
                    <tr>
                        <th class="center">#</th>
                        <th>Item</th>
                        <th class="right">Unit Cost</th>
                        <th class="center">Qty</th>
                        <th class="right">Tax %</th>
                        <th class="right">Discount</th>
                        <th class="right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quote->items as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="left fw-bold">{{ $item->description }}</td>
                        <td class="right">{{ format_currency($item->unit_price) }}</td>
                        <td class="center">{{ $item->quantity }}</td>
                        <td class="right">{{ $item->tax_percentage }}%</td>
                        <td class="right">{{ format_currency($item->discount) }}</td>
                        <td class="right fw-bold">{{ format_currency($item->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-lg-4 col-sm-5 ms-auto">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Subtotal</strong>
                            </td>
                            <td class="right text-end">{{ format_currency($quote->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Total Tax</strong>
                            </td>
                            <td class="right text-end">{{ format_currency($quote->total_tax) }}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Total Discount</strong>
                            </td>
                            <td class="right text-end">-{{ format_currency($quote->total_discount) }}</td>
                        </tr>
                        @if($quote->shipping > 0)
                        <tr>
                            <td class="left">
                                <strong class="text-dark">Shipping</strong>
                            </td>
                            <td class="right text-end">{{ format_currency($quote->shipping) }}</td>
                        </tr>
                        @endif
                        <tr class="table-light">
                            <td class="left">
                                <strong class="text-dark">Grand Total</strong>
                            </td>
                            <td class="right text-end">
                                <strong class="text-dark fs-5">{{ format_currency($quote->grand_total) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($quote->notes)
        <div class="mt-5 pt-4 border-top">
            <h6 class="text-muted mb-2">Notes:</h6>
            <div class="text-secondary">{{ $quote->notes }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
