@extends('admin.layouts.app')

@section('title', 'Quote ' . $quote->quote_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('quotes.index') }}" class="btn btn-light btn-sm rounded-circle me-3 shadow-sm">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <h2 class="fw-bold text-dark mb-0">Quote Detail</h2>
        <span class="badge-soft badge-soft-primary ms-3">{{ $quote->quote_number }}</span>
    </div>
    <div class="d-flex gap-2">
        @if($quote->status != 'Invoiced')
        <a href="{{ route('quotes.convert', $quote) }}" class="btn btn-primary-modern d-flex align-items-center shadow-sm" onclick="return confirm('Convert this quote to an Invoice?')">
            <i class="fas fa-exchange-alt me-2"></i> Convert to Invoice
        </a>
        @endif
        <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-outline-secondary border-2 d-flex align-items-center fw-medium">
            <i class="fas fa-file-pdf me-2"></i> Download PDF
        </a>
        <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-outline-info border-2 d-flex align-items-center fw-medium">
            <i class="fas fa-edit me-2"></i> Edit
        </a>
    </div>
</div>

<x-card :padding="false" class="overflow-hidden">
    <div class="p-5">
        <div class="row mb-5">
            <div class="col-sm-6">
                <label class="text-uppercase text-muted fw-bold small mb-3 d-block">From</label>
                @php $setting = \App\Models\Setting::first(); @endphp
                <h5 class="fw-bold text-dark mb-1">{{ $setting->company_name ?? 'My Company' }}</h5>
                <p class="text-muted mb-0">
                    {{ $setting->company_address ?? 'Address not set' }}<br>
                    <i class="fas fa-envelope me-1 small"></i> {{ $setting->company_email ?? 'email@example.com' }}<br>
                    <i class="fas fa-phone me-1 small"></i> {{ $setting->company_phone ?? '+00 000 0000' }}
                </p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <label class="text-uppercase text-muted fw-bold small mb-3 d-block">Prepared For</label>
                <h5 class="fw-bold text-dark mb-1">{{ $quote->customer->name }}</h5>
                <p class="text-muted mb-0">
                    {{ $quote->customer->address }}<br>
                    {{ $quote->customer->city }}, {{ $quote->customer->zip }}, {{ $quote->customer->country }}<br>
                    <i class="fas fa-envelope me-1 small"></i> {{ $quote->customer->email }}
                </p>
            </div>
        </div>

        <div class="row mb-5 py-3 border-top border-bottom bg-light-subtle">
            <div class="col-3">
                <span class="text-muted small d-block">Quote Date</span>
                <span class="fw-bold text-dark">{{ $quote->quote_date }}</span>
            </div>
            <div class="col-3">
                <span class="text-muted small d-block">Due Date</span>
                <span class="fw-bold text-dark">{{ $quote->due_date ?? 'N/A' }}</span>
            </div>
            <div class="col-3">
                <span class="text-muted small d-block">Status</span>
                @php
                    $statusClass = match($quote->status) {
                        'Accepted' => 'badge-soft-success',
                        'Sent' => 'badge-soft-info',
                        'Invoiced' => 'badge-soft-primary',
                        'Declined' => 'badge-soft-danger',
                        default => 'badge-soft-warning'
                    };
                @endphp
                <span class="badge-soft {{ $statusClass }}">{{ $quote->status }}</span>
            </div>
            <div class="col-3 text-end">
                <span class="text-muted small d-block">Reference</span>
                <span class="fw-bold text-primary">{{ $quote->reference ?? 'N/A' }}</span>
            </div>
        </div>

        <x-table class="mb-5">
            <x-slot name="thead">
                <th style="width: 5%" class="ps-0">#</th>
                <th style="width: 45%">Description</th>
                <th style="width: 15%" class="text-end">Unit Price</th>
                <th style="width: 10%" class="text-center">Qty</th>
                <th style="width: 10%" class="text-center">Tax %</th>
                <th style="width: 15%" class="text-end pe-0">Total</th>
            </x-slot>

            @foreach($quote->items as $index => $item)
            <tr class="align-middle">
                <td class="ps-0 text-muted">{{ $index + 1 }}</td>
                <td class="fw-medium text-dark">{{ $item->description }}</td>
                <td class="text-end text-muted">{{ format_currency($item->unit_price) }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">{{ $item->tax_percentage }}%</td>
                <td class="text-end pe-0 fw-bold text-dark">{{ format_currency($item->total) }}</td>
            </tr>
            @endforeach
        </x-table>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="d-flex flex-column gap-3 p-4 bg-light rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-medium text-dark">{{ format_currency($quote->subtotal) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Tax</span>
                        <span class="fw-medium text-dark">{{ format_currency($quote->total_tax) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Discount</span>
                        <span class="fw-medium text-danger">-{{ format_currency($quote->total_discount) }}</span>
                    </div>
                    @if($quote->shipping > 0)
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-medium text-dark">{{ format_currency($quote->shipping) }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="fw-bold text-dark fs-5">Grand Total</span>
                        <span class="fw-bold text-primary fs-5">{{ format_currency($quote->grand_total) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($quote->notes)
        <div class="mt-5 pt-4 border-top">
            <h6 class="fw-bold text-dark mb-2">Notes:</h6>
            <p class="text-muted mb-0 small">{{ $quote->notes }}</p>
        </div>
        @endif

        @if($quote->images && count($quote->images) > 0)
        <div class="mt-5 pt-4 border-top">
            <h6 class="fw-bold text-dark mb-3">Attached Images:</h6>
            <div class="row g-3">
                @foreach($quote->images as $index => $image)
                <div class="col-md-3">
                    <div class="position-relative overflow-hidden rounded-3 shadow-sm" style="cursor: pointer;" onclick="showImageModal('{{ asset($image) }}')">
                        <img src="{{ asset($image) }}" class="img-fluid w-100" style="height: 200px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white p-2 text-center">
                            <i class="fas fa-search-plus"></i> View
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-card>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img id="modalImage" src="" class="img-fluid w-100 rounded-3">
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>
@endsection
@endsection
