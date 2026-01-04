@extends('admin.layouts.app')

@section('title', 'Company Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Company Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ $setting->company_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="company_email" class="form-control" value="{{ $setting->company_email }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Phone</label>
                                <input type="text" name="company_phone" class="form-control" value="{{ $setting->company_phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax ID / GSTIN</label>
                                <input type="text" name="company_tax_id" class="form-control" value="{{ $setting->company_tax_id }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Company Address</label>
                                <textarea name="company_address" class="form-control" rows="3">{{ $setting->company_address }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Currency Symbol</label>
                                <input type="text" name="currency_symbol" class="form-control" value="{{ $setting->currency_symbol ?: '$' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Prefix</label>
                                <input type="text" name="invoice_prefix" class="form-control" value="{{ $setting->invoice_prefix ?: 'INV-' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quote Prefix</label>
                                <input type="text" name="quote_prefix" class="form-control" value="{{ $setting->quote_prefix ?: 'QT-' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control">
                                @if($setting->company_logo)
                                    <div class="mt-2">
                                        <img src="{{ asset($setting->company_logo) }}" alt="Logo" style="height: 50px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
