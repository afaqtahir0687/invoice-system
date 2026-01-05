@extends('admin.layouts.app')

@section('title', 'Create New Quote')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Create Quote</h2>
    <div class="d-flex align-items-center bg-white px-3 py-2 rounded-3 shadow-sm border">
        <span class="text-muted me-2 small fw-medium">Quote Number:</span>
        <span class="fw-bold text-primary">{{ $quoteNumber }}</span>
    </div>
</div>

<form action="{{ route('quotes.store') }}" method="POST" id="quote-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="quote_number" value="{{ $quoteNumber }}">
    
    <div class="row g-4">
        <div class="col-lg-12">
            <x-card title="Quote Details">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <label for="customer_id">Customer *</label>
                            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-form-input label="Quote Date *" name="quote_date" type="date" :value="date('Y-m-d')" required />
                    </div>
                    <div class="col-md-4">
                        <x-form-input label="Due Date" name="due_date" type="date" :value="date('Y-m-d', strtotime('+15 days'))" />
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-lg-12">
            <x-card title="Quote Items" :padding="false">
                <x-table>
                    <x-slot name="thead">
                        <th style="width: 40%">Description</th>
                        <th style="width: 15%">Unit Price</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 10%">Tax %</th>
                        <th style="width: 10%">Discount</th>
                        <th style="width: 10%">Total</th>
                        <th style="width: 5%" class="text-center"></th>
                    </x-slot>

                    <tbody id="item-rows">
                        <!-- Items will be added here via JS -->
                    </tbody>
                </x-table>
                
                <div class="p-3 border-top bg-light-subtle rounded-bottom-4">
                    <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center" id="add-item">
                        <i class="fas fa-plus me-2"></i> Add Item Row
                    </button>
                </div>
            </x-card>
        </div>

        <div class="col-md-7">
            <x-card title="Additional Information">
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium small">Payment Terms & Conditions</label>
                    <textarea name="terms" class="form-control" rows="3">1. This quote is valid for 30 days.
2. Prices are subject to change after the validity period.</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium small">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes for the customer..."></textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted fw-medium small">Attach Images (Optional)</label>
                    <div class="border-2 border-dashed rounded-3 p-4 text-center bg-light-subtle" id="drop-zone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-2">Drag & drop images here or click to browse</p>
                        <p class="text-muted small mb-3">Maximum 5 images, 2MB each (JPG, PNG, GIF)</p>
                        <input type="file" name="images[]" id="image-input" class="d-none" multiple accept="image/jpeg,image/jpg,image/png,image/gif">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('image-input').click()">
                            <i class="fas fa-folder-open me-2"></i>Browse Files
                        </button>
                    </div>
                    <div id="image-preview" class="mt-3 row g-2"></div>
                </div>
            </x-card>
        </div>

        <div class="col-md-5">
            <x-card title="Summary">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <div class="input-group input-group-sm w-50">
                            <span class="input-group-text border-0 bg-transparent">$</span>
                            <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control text-end border-0 bg-transparent fw-semibold" readonly value="0.00">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Tax</span>
                        <div class="input-group input-group-sm w-50">
                            <span class="input-group-text border-0 bg-transparent">$</span>
                            <input type="number" step="0.01" name="total_tax" id="total_tax" class="form-control text-end border-0 bg-transparent fw-semibold" readonly value="0.00">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Discount</span>
                        <div class="input-group input-group-sm w-50">
                            <span class="input-group-text border-0 bg-transparent">-$</span>
                            <input type="number" step="0.01" name="total_discount" id="total_discount" class="form-control text-end border-0 bg-transparent fw-semibold" readonly value="0.00">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-muted">Shipping</span>
                        <div class="input-group input-group-sm w-50">
                            <span class="input-group-text border-0 bg-light">$</span>
                            <input type="number" step="0.01" name="shipping" id="shipping" class="form-control text-end border-1 rounded-2" value="0.00">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded-3">
                        <span class="fw-bold text-dark fs-5">Grand Total</span>
                        <div class="input-group w-50">
                            <span class="input-group-text border-0 bg-transparent fs-5 fw-bold">$</span>
                            <input type="number" step="0.01" name="grand_total" id="grand_total" class="form-control text-end border-0 bg-transparent fs-5 fw-bold" readonly value="0.00">
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-grid gap-2">
                    <button type="submit" class="btn btn-primary-modern py-3">
                        <i class="fas fa-save me-2"></i> Save Quote
                    </button>
                    <a href="{{ route('quotes.index') }}" class="btn btn-link text-muted">Cancel and Go Back</a>
                </div>
            </x-card>
        </div>
    </div>
</form>

<template id="item-template">
    <tr class="item-row">
        <td><input type="text" name="items[INDEX][description]" class="form-control form-control-sm border-0 shadow-none bg-transparent" placeholder="Enter item description" required></td>
        <td><input type="number" step="0.01" name="items[INDEX][unit_price]" class="form-control form-control-sm unit-price text-end rounded-2" value="0.00" required></td>
        <td><input type="number" name="items[INDEX][quantity]" class="form-control form-control-sm quantity text-center rounded-2" value="1" required></td>
        <td><input type="number" step="0.01" name="items[INDEX][tax_percentage]" class="form-control form-control-sm tax-percentage text-center rounded-2" value="0.00"></td>
        <td><input type="number" step="0.01" name="items[INDEX][discount]" class="form-control form-control-sm discount text-end rounded-2" value="0.00"></td>
        <td><input type="number" step="0.01" name="items[INDEX][total]" class="form-control form-control-sm line-total border-0 bg-transparent text-end fw-semibold" readonly value="0.00"></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-link text-danger remove-item p-0">
                <i class="fas fa-trash-alt"></i>
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
        tr.className = 'item-row align-middle';
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
    document.getElementById('quote-form').addEventListener('input', (e) => {
        if (e.target.classList.contains('unit-price') || 
            e.target.classList.contains('quantity') || 
            e.target.classList.contains('tax-percentage') || 
            e.target.classList.contains('discount') ||
            e.target.id === 'shipping') {
            calculate();
        }
    });

    itemRows.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove();
            calculate();
        }
    });

    // Add initial row
    addRow();

    // Image Upload Functionality
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const dropZone = document.getElementById('drop-zone');
    let selectedFiles = [];

    // Handle file selection
    imageInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    // Drag and drop handlers
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-primary-subtle');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary-subtle');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary-subtle');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        const maxFiles = 5;
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

        // Check total file count
        if (selectedFiles.length + files.length > maxFiles) {
            alert(`You can only upload a maximum of ${maxFiles} images.`);
            return;
        }

        Array.from(files).forEach(file => {
            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                alert(`${file.name} is not a valid image type. Only JPG, PNG, and GIF are allowed.`);
                return;
            }

            // Validate file size
            if (file.size > maxSize) {
                alert(`${file.name} is too large. Maximum file size is 2MB.`);
                return;
            }

            selectedFiles.push(file);
            displayImagePreview(file);
        });

        updateFileInput();
    }

    function displayImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-3';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail rounded-3" style="height: 150px; width: 100%; object-fit: cover;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle" 
                            onclick="removeImage('${file.name}')" style="width: 30px; height: 30px; padding: 0;">
                        <i class="fas fa-times"></i>
                    </button>
                    <p class="text-muted small mt-2 mb-0 text-truncate">${file.name}</p>
                </div>
            `;
            imagePreview.appendChild(col);
        };
        reader.readAsDataURL(file);
    }

    window.removeImage = function(fileName) {
        selectedFiles = selectedFiles.filter(f => f.name !== fileName);
        updateFileInput();
        renderPreviews();
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }

    function renderPreviews() {
        imagePreview.innerHTML = '';
        selectedFiles.forEach(file => displayImagePreview(file));
    }
</script>
@endsection
@endsection
