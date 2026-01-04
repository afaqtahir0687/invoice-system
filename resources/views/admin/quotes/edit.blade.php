@extends('admin.layouts.app')

@section('title', 'Edit Quote')

@section('content')
<form action="{{ route('quotes.update', $quote) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Quote: {{ $quote->quote_number }}</h5>
            <input type="hidden" name="quote_number" value="{{ $quote->quote_number }}">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Customer *</label>
                    <select name="customer_id" class="form-select" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $quote->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Quote Date *</label>
                    <input type="date" name="quote_date" class="form-control" value="{{ $quote->quote_date }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="{{ $quote->due_date }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Reference</label>
                    <input type="text" name="reference" class="form-control" value="{{ $quote->reference }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Draft" {{ $quote->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Sent" {{ $quote->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                        <option value="Accepted" {{ $quote->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ $quote->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Items</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%">Description</th>
                        <th style="width: 15%">Unit Price</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 10%">Tax %</th>
                        <th style="width: 10%">Discount</th>
                        <th style="width: 10%">Total</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="item-rows">
                    @foreach($quote->items as $index => $item)
                    <tr class="item-row">
                        <td><input type="text" name="items[{{ $index }}][description]" class="form-control form-control-sm" value="{{ $item->description }}" required></td>
                        <td><input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control form-control-sm unit-price" value="{{ $item->unit_price }}" required></td>
                        <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control form-control-sm quantity" value="{{ $item->quantity }}" required></td>
                        <td><input type="number" step="0.01" name="items[{{ $index }}][tax_percentage]" class="form-control form-control-sm tax-percentage" value="{{ $item->tax_percentage }}"></td>
                        <td><input type="number" step="0.01" name="items[{{ $index }}][discount]" class="form-control form-control-sm discount" value="{{ $item->discount }}"></td>
                        <td><input type="number" step="0.01" name="items[{{ $index }}][total]" class="form-control form-control-sm line-total border-0 bg-transparent text-end" readonly value="{{ $item->total }}"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="fas fa-times"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-3"><button type="button" class="btn btn-sm btn-outline-primary" id="add-item"><i class="fas fa-plus"></i> Add Row</button></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card"><div class="card-body"><textarea name="notes" class="form-control" rows="5">{{ $quote->notes }}</textarea></div></div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr><td>Subtotal</td><td><input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control form-control-sm text-end border-0" readonly value="{{ $quote->subtotal }}"></td></tr>
                        <tr><td>Total Tax</td><td><input type="number" step="0.01" name="total_tax" id="total_tax" class="form-control form-control-sm text-end border-0" readonly value="{{ $quote->total_tax }}"></td></tr>
                        <tr><td>Total Discount</td><td><input type="number" step="0.01" name="total_discount" id="total_discount" class="form-control form-control-sm text-end border-0" readonly value="{{ $quote->total_discount }}"></td></tr>
                        <tr><td>Shipping</td><td><input type="number" step="0.01" name="shipping" id="shipping" class="form-control form-control-sm text-end" value="{{ $quote->shipping }}"></td></tr>
                        <tr class="table-light fw-bold"><td>Grand Total</td><td><input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control form-control-sm text-end border-0 fw-bold" readonly value="{{ $quote->grand_total }}"></td></tr>
                    </table>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('quotes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-lg btn-primary px-5">Update Quote</button>
            </div>
        </div>
    </div>
</form>

<template id="item-template">
    <tr class="item-row">
        <td><input type="text" name="items[INDEX][description]" class="form-control form-control-sm" required></td>
        <td><input type="number" step="0.01" name="items[INDEX][unit_price]" class="form-control form-control-sm unit-price" value="0.00" required></td>
        <td><input type="number" name="items[INDEX][quantity]" class="form-control form-control-sm quantity" value="1" required></td>
        <td><input type="number" step="0.01" name="items[INDEX][tax_percentage]" class="form-control form-control-sm tax-percentage" value="0.00"></td>
        <td><input type="number" step="0.01" name="items[INDEX][discount]" class="form-control form-control-sm discount" value="0.00"></td>
        <td><input type="number" step="0.01" name="items[INDEX][total]" class="form-control form-control-sm line-total border-0 bg-transparent text-end" readonly value="0.00"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="fas fa-times"></i></button></td>
    </tr>
</template>

@section('scripts')
<script>
    let rowIndex = {{ $quote->items->count() }};
    const itemRows = document.getElementById('item-rows');
    const template = document.getElementById('item-template').innerHTML;

    function addRow() {
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = template.replace(/INDEX/g, rowIndex++);
        itemRows.appendChild(tr);
        calculate();
    }

    function calculate() {
        let subtotal = 0, totalTax = 0, totalDiscount = 0;
        const shipping = parseFloat(document.getElementById('shipping').value) || 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.unit-price').value) || 0;
            const qty = parseFloat(row.querySelector('.quantity').value) || 0;
            const taxP = parseFloat(row.querySelector('.tax-percentage').value) || 0;
            const disc = parseFloat(row.querySelector('.discount').value) || 0;
            const lineSubtotal = price * qty;
            const lineTax = lineSubtotal * (taxP / 100);
            const lineTotal = lineSubtotal + lineTax - disc;
            row.querySelector('.line-total').value = lineTotal.toFixed(2);
            subtotal += lineSubtotal; totalTax += lineTax; totalDiscount += disc;
        });
        const grandTotal = subtotal + totalTax - totalDiscount + shipping;
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('total_tax').value = totalTax.toFixed(2);
        document.getElementById('total_discount').value = totalDiscount.toFixed(2);
        document.getElementById('grand_total').value = grandTotal.toFixed(2);
    }

    document.getElementById('add-item').addEventListener('click', addRow);
    document.getElementById('item-rows').addEventListener('input', calculate);
    document.getElementById('shipping').addEventListener('input', calculate);
    document.getElementById('item-rows').addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove(); calculate();
        }
    });
</script>
@endsection
@endsection
