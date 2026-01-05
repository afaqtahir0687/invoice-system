<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; font-size: 13px; line-height: 1.5; margin: 0; padding: 0; background: #fff; }
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; }
        .header { margin-bottom: 50px; }
        .company-info { width: 50%; float: left; }
        .customer-info { width: 50%; float: right; text-align: right; }
        .clear { clear: both; }
        .logo { max-height: 60px; margin-bottom: 15px; }
        .invoice-title { font-size: 32px; font-weight: bold; color: #4f46e5; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
        
        .info-strip { background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 40px; }
        .info-strip table { border: none !important; width: 100%; }
        .info-strip td { border: none !important; padding: 0; vertical-align: top; }
        .info-label { color: #64748b; font-size: 11px; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 4px; }
        .info-value { color: #1e293b; font-weight: bold; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table thead th { background: #f1f5f9; padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: left; color: #475569; font-size: 11px; text-transform: uppercase; }
        table tbody td { padding: 15px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        
        .totals-container { float: right; width: 280px; margin-top: 10px; }
        .total-row { padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .total-row.grand-total { border-top: 1px solid #4f46e5; border-bottom: none; background: #f8fafc; padding: 15px 10px; margin-top: 10px; }
        .total-label { float: left; color: #64748b; }
        .total-value { float: right; font-weight: bold; color: #1e293b; }
        .grand-total .total-label { color: #1e293b; font-weight: bold; font-size: 16px; }
        .grand-total .total-value { color: #4f46e5; font-weight: bold; font-size: 16px; }
        
        .footer { margin-top: 100px; text-align: center; color: #94a3b8; font-size: 11px; border-top: 1px solid #f1f5f9; padding-top: 20px; }
        .notes-section { margin-top: 50px; background: #fff; border-left: 4px solid #e2e8f0; padding-left: 15px; }
        .notes-title { font-weight: bold; color: #475569; font-size: 12px; margin-bottom: 5px; }
        .notes-content { color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                @if($setting->company_logo)
                    <img src="{{ public_path($setting->company_logo) }}" class="logo">
                @else
                    <div style="font-size: 24px; font-weight: bold; color: #4f46e5; margin-bottom: 10px;">{{ $setting->company_name }}</div>
                @endif
                <div style="color: #64748b;">
                    {{ $setting->company_address }}<br>
                    {{ $setting->company_phone }}<br>
                    {{ $setting->company_email }}
                </div>
            </div>
            <div class="customer-info">
                <div class="invoice-title">INVOICE</div>
                <div style="font-size: 16px; font-weight: bold; color: #1e293b;">#{{ $invoice->invoice_number }}</div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="info-strip">
            <table>
                <tr>
                    <td style="width: 30%;">
                        <span class="info-label">Bill To</span>
                        <div class="info-value">{{ $invoice->customer->name }}</div>
                        <div style="color: #64748b; margin-top: 4px; font-size: 12px;">
                            {{ $invoice->customer->address }}<br>
                            {{ $invoice->customer->city }}, {{ $invoice->customer->country }}
                        </div>
                    </td>
                    <td style="width: 23%;">
                        <span class="info-label">Invoice Date</span>
                        <div class="info-value">{{ $invoice->invoice_date }}</div>
                    </td>
                    <td style="width: 23%;">
                        <span class="info-label">Due Date</span>
                        <div class="info-value">{{ $invoice->due_date }}</div>
                    </td>
                    <td style="width: 24%; text-align: right;">
                        <span class="info-label">Balance Due</span>
                        <div class="info-value" style="color: #ef4444; font-size: 18px;">{{ format_currency($invoice->balance_due) }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%">Description</th>
                    <th style="text-align: right; width: 15%">Price</th>
                    <th style="text-align: center; width: 15%">Qty</th>
                    <th style="text-align: right; width: 20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td style="font-weight: bold;">{{ $item->description }}</td>
                    <td style="text-align: right">{{ format_currency($item->unit_price) }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ format_currency($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-container">
            <div class="total-row">
                <span class="total-label">Subtotal</span>
                <span class="total-value">{{ format_currency($invoice->subtotal) }}</span>
                <div class="clear"></div>
            </div>
            <div class="total-row">
                <span class="total-label">Tax</span>
                <span class="total-value">{{ format_currency($invoice->total_tax) }}</span>
                <div class="clear"></div>
            </div>
            <div class="total-row grand-total">
                <span class="total-label">Grand Total</span>
                <span class="total-value">{{ format_currency($invoice->grand_total) }}</span>
                <div class="clear"></div>
            </div>
            <div class="total-row" style="color: #16a34a;">
                <span class="total-label" style="color: #16a34a;">Amount Paid</span>
                <span class="total-value">{{ format_currency($invoice->amount_paid) }}</span>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>

        @if($invoice->notes)
        <div class="notes-section">
            <div class="notes-title">Notes / Terms:</div>
            <div class="notes-content">{{ $invoice->notes }}</div>
        </div>
        @endif

        <div class="footer">
            <div style="margin-bottom: 5px; font-weight: bold; color: #475569;">{{ $setting->company_name }}</div>
            <div>Thank you for your business! If you have any questions, please contact us at {{ $setting->company_email }}</div>
        </div>
    </div>
</body>
</html>
