<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 14px; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; }
        .header { margin-bottom: 40px; }
        .company-info { width: 50%; float: left; }
        .customer-info { width: 50%; float: right; text-align: right; }
        .clear { clear: both; }
        .logo { max-height: 80px; margin-bottom: 10px; }
        .title { font-size: 28px; font-weight: bold; color: #198754; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th { background: #f8f9fa; padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        table td { padding: 12px; border-bottom: 1px solid #eee; }
        .totals { float: right; width: 250px; margin-top: 20px; }
        .footer { margin-top: 50px; text-align: center; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                @if($setting->company_logo)
                    <img src="{{ public_path($setting->company_logo) }}" class="logo">
                @endif
                <div style="font-size: 18px; font-weight: bold;">{{ $setting->company_name }}</div>
                <div>{{ $setting->company_address }}</div>
                <div>{{ $setting->company_phone }}</div>
                <div>{{ $setting->company_email }}</div>
            </div>
            <div class="customer-info">
                <div class="title">INVOICE</div>
                <div><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</div>
                <div><strong>Date:</strong> {{ $invoice->invoice_date }}</div>
                <div><strong>Due Date:</strong> {{ $invoice->due_date }}</div>
            </div>
            <div class="clear"></div>
        </div>

        <div style="margin-bottom: 30px;">
            <div style="font-weight: bold; color: #777;">BILL TO:</div>
            <strong>{{ $invoice->customer->name }}</strong>
            <div>{{ $invoice->customer->address }}</div>
            <div>{{ $invoice->customer->city }}, {{ $invoice->customer->zip }}</div>
            <div>{{ $invoice->customer->country }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right">Price</th>
                    <th style="text-align: center">Qty</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: right">{{ format_currency($item->unit_price) }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: right">{{ format_currency($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table style="border: none">
                <tr>
                    <td style="border: none">Subtotal:</td>
                    <td style="border: none; text-align: right">{{ format_currency($invoice->subtotal) }}</td>
                </tr>
                <tr>
                    <td style="border: none">Tax:</td>
                    <td style="border: none; text-align: right">{{ format_currency($invoice->total_tax) }}</td>
                </tr>
                <tr style="font-weight: bold; border-top: 1px solid #ddd">
                    <td style="border: none">Grand Total:</td>
                    <td style="border: none; text-align: right">{{ format_currency($invoice->grand_total) }}</td>
                </tr>
                <tr style="color: #198754">
                    <td style="border: none">Paid:</td>
                    <td style="border: none; text-align: right">{{ format_currency($invoice->amount_paid) }}</td>
                </tr>
                <tr style="color: #dc3545; font-weight: bold;">
                    <td style="border: none">Balance Due:</td>
                    <td style="border: none; text-align: right">{{ format_currency($invoice->balance_due) }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>

        @if($invoice->terms)
        <div style="margin-top: 40px">
            <div style="font-weight: bold;">Terms & Conditions:</div>
            <div style="color: #555; font-size: 12px;">{{ $invoice->terms }}</div>
        </div>
        @endif

        <div class="footer">
            <div>{{ $setting->company_name }} | Thank you for your business!</div>
        </div>
    </div>
</body>
</html>
