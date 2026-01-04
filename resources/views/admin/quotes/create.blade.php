@extends('admin.layouts.app')

@section('title', 'Create Quote')

@section('content')
<form action="{{ route('quotes.store') }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quote Information</h5>
            <span class="badge bg-primary fs-6">{{ $quoteNumber }}</span>
            <input type="hidden" name="quote_number" value="{{ $quoteNumber }}">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Customer *</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company_name ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Quote Date *</label>
                    <input type="date" name="quote_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Reference (Optional)</label>
                    <input type="text" name="reference" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Items</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0" id="items-table">
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
                    <!-- Rows will be added here -->
                </tbody>
            </table>
            <div class="p-3">
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-item">
                    <i class="fas fa-plus me-1"></i> Add Row
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <label class="form-label">Notes / Proposal Text</label>
                    <textarea name="notes" class="form-control" rows="5" placeholder="Enter any extra notes..."></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end">
                                <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control form-control-sm text-end border-0 bg-transparent" readonly value="0.00">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Tax</td>
                            <td class="text-end">
                                <input type="number" step="0.01" name="total_tax" id="total_tax" class="form-control form-control-sm text-end border-0 bg-transparent" readonly value="0.00">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Discount</td>
                            <td class="text-end">
                                <input type="number" step="0.01" name="total_discount" id="total_discount" class="form-control form-control-sm text-end border-0 bg-transparent" readonly value="0.00">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Shipping</td>
                            <td>
                                <input type="number" step="0.01" name="shipping" id="shipping" class="form-control form-control-sm text-end" value="0.00">
                            </td>
                        </tr>
                        <tr class="table-light fw-bold">
                            <td>Grand Total</td>
                            <td class="text-end">
                                <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control form-control-sm text-end border-0 bg-transparent fw-bold" readonly value="0.00">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('quotes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-lg btn-primary px-5">Create Quote</button>
            </div>
        </div>
    </div>
</form>

<template id="item-template">
    <tr class="item-row">
        <td>
            <input type="text" name="items[INDEX][description]" class="form-control form-control-sm" required>
        </td>
        <td>
            <input type="number" step="0.01" name="items[INDEX][unit_price]" class="form-control form-control-sm unit-price" value="0.00" required>
        </td>
        <td>
            <input type="number" name="items[INDEX][quantity]" class="form-control form-control-sm quantity" value="1" required>
        </td>
        <td>
            <input type="number" step="0.01" name="items[INDEX][tax_percentage]" class="form-control form-control-sm tax-percentage" value="0.00">
        </td>
        <td>
            <input type="number" step="0.01" name="items[INDEX][discount]" class="form-control form-control-sm discount" value="0.00">
        </td>
        <td>
            <input type="number" step="0.01" name="items[INDEX][total]" class="form-control form-control-sm line-total border-0 bg-transparent text-end" readonly value="0.00">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                <i class="fas fa-times"></i>
            </button>
        </td>
    </tr>
</template>

@section('scripts')
<script>
    let rowIndex = 0;
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
        let subtotal = 0;
        let totalTax = 0;
        let totalDiscount = 0;
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

            subtotal += lineSubtotal;
            totalTax += lineTax;
            totalDiscount += disc;
        });

        const grandTotal = subtotal + totalTax - totalDiscount + shipping;

        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('total_tax').value = totalTax.toFixed(2);
        document.getElementById('total_discount').value = totalDiscount.toFixed(2);
        document.getElementById('grand_total').value = grandTotal.toFixed(2);
    }

    document.getElementById('add-item').addEventListener('click', addRow);

    document.getElementById('item-rows').addEventListener('input', function(e) {
        if (e.target.classList.contains('unit-price') || 
            e.target.classList.contains('quantity') || 
            e.target.classList.contains('tax-percentage') || 
            e.target.classList.contains('discount')) {
            calculate();
        }
    });

    document.getElementById('shipping').addEventListener('input', calculate);

    document.getElementById('item-rows').addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove();
            calculate();
        }
    });

    // Initial first row
    addRow();
</script>
@endsection
@endsection
