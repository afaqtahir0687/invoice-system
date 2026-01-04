@extends('admin.layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Invoice Details: {{ $invoice->invoice_number }}</h4>
    <div>
        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#paymentModal">
            <i class="fas fa-plus me-1"></i> Record Payment
        </button>
        <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-5">
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <h6 class="mb-3 text-muted">From:</h6>
                        @php $setting = \App\Models\Setting::first(); @endphp
                        <strong>{{ $setting->company_name }}</strong>
                        <div>{{ $setting->company_address }}</div>
                        <div>Email: {{ $setting->company_email }}</div>
                        <div>Phone: {{ $setting->company_phone }}</div>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="mb-3 text-muted">To:</h6>
                        <strong>{{ $invoice->customer->name }}</strong>
                        <div>{{ $invoice->customer->address }}</div>
                        <div>{{ $invoice->customer->city }}, {{ $invoice->customer->zip }}</div>
                        <div>{{ $invoice->customer->country }}</div>
                        <div>Email: {{ $invoice->customer->email }}</div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Cost</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                            <tr>
                                <td class="fw-bold">{{ $item->description }}</td>
                                <td class="text-end">{{ format_currency($item->unit_price) }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">{{ format_currency($item->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-lg-4 col-sm-5 ms-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end">{{ format_currency($invoice->subtotal) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax</strong></td>
                                    <td class="text-end">{{ format_currency($invoice->total_tax) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total</strong></td>
                                    <td class="text-end font-weight-bold"><strong>{{ format_currency($invoice->grand_total) }}</strong></td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Amount Paid</strong></td>
                                    <td class="text-end"><strong>{{ format_currency($invoice->amount_paid) }}</strong></td>
                                </tr>
                                <tr class="table-danger">
                                    <td><strong>Balance Due</strong></td>
                                    <td class="text-end"><strong>{{ format_currency($invoice->balance_due) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Payment History</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($invoice->payments as $payment)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <strong>{{ format_currency($payment->amount) }}</strong>
                            <small class="text-muted">{{ $payment->payment_date }}</small>
                        </div>
                        <small class="text-muted">{{ $payment->payment_method }}</small>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4">No payments yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('payments.store', $invoice) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Record Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ $invoice->balance_due }}" max="{{ $invoice->balance_due }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Check">Check</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
