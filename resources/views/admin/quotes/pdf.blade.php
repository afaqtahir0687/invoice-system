<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $quote->quote_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 14px; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .company-info { width: 50%; float: left; }
        .customer-info { width: 50%; float: right; text-align: right; }
        .clear { clear: both; }
        .logo { max-height: 80px; margin-bottom: 10px; }
        .invoice-details { margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .title { font-size: 28px; font-weight: bold; color: #0d6efd; margin-bottom: 10px; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table th { background: #f8f9fa; color: #555; padding: 12px; border-bottom: 1px solid #eee; }
        table td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: top; }
        .totals { margin-top: 30px; float: right; width: 300px; }
        .totals-row { display: flex; justify-content: space-between; padding: 5px 0; }
        .grand-total { font-size: 18px; font-weight: bold; color: #0d6efd; border-top: 2px solid #0d6efd; margin-top: 10px; padding-top: 10px; }
        .footer { margin-top: 50px; text-align: center; color: #777; font-size: 12px; border-top: 1px solid #eee; padding-top: 20px; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; color: white; background: #6c757d; }
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
                <div class="title">QUOTE</div>
                <div><strong>Quote #:</strong> {{ $quote->quote_number }}</div>
                <div><strong>Date:</strong> {{ $quote->quote_date }}</div>
                <div><strong>Due Date:</strong> {{ $quote->due_date }}</div>
                @if($quote->reference)
                    <div><strong>Ref:</strong> {{ $quote->reference }}</div>
                @endif
            </div>
        </div>
        
        <div class="clear"></div>

        <div style="margin-top: 40px; margin-bottom: 30px;">
            <div style="font-weight: bold; color: #777; text-transform: uppercase;">Bill To:</div>
            <div style="font-size: 16px; font-weight: bold;">{{ $quote->customer->name }}</div>
            @if($quote->customer->company_name)
                <div>{{ $quote->customer->company_name }}</div>
            @endif
            <div>{{ $quote->customer->address }}</div>
            <div>{{ $quote->customer->city }}, {{ $quote->customer->zip }}</div>
            <div>{{ $quote->customer->country }}</div>
            <div>{{ $quote->customer->phone }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%">Description</th>
                    <th style="text-align: right">Price</th>
                    <th style="text-align: center">Qty</th>
                    <th style="text-align: right">Tax</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: right">{{ format_currency($item->unit_price) }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: right">{{ $item->tax_percentage }}%</td>
                    <td style="text-align: right">{{ format_currency($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div style="width: 100%">
                <table style="border: none">
                    <tr>
                        <td style="border: none">Subtotal:</td>
                        <td style="border: none; text-align: right">{{ format_currency($quote->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td style="border: none">Tax:</td>
                        <td style="border: none; text-align: right">{{ format_currency($quote->total_tax) }}</td>
                    </tr>
                    <tr>
                        <td style="border: none">Discount:</td>
                        <td style="border: none; text-align: right">-{{ format_currency($quote->total_discount) }}</td>
                    </tr>
                    @if($quote->shipping > 0)
                    <tr>
                        <td style="border: none">Shipping:</td>
                        <td style="border: none; text-align: right">{{ format_currency($quote->shipping) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="border: none; font-weight: bold; border-top: 1px solid #ddd">Grand Total:</td>
                        <td style="border: none; text-align: right; font-weight: bold; font-size: 16px; color: #0d6efd; border-top: 1px solid #ddd">
                            {{ format_currency($quote->grand_total) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="clear"></div>

        @if($quote->notes)
        <div style="margin-top: 50px">
            <div style="font-weight: bold; margin-bottom: 5px">Notes:</div>
            <div style="color: #555">{{ $quote->notes }}</div>
        </div>
        @endif

        <div class="footer">
            <div>{{ $setting->company_name }} | {{ $setting->company_email }}</div>
            <div>Thank you for your business!</div>
        </div>
    </div>
</body>
</html>
