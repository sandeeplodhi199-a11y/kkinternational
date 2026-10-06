<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $quotation->quotation_no }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; padding: 40px; font-size: 13px; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #1b4d3e; padding-bottom: 20px; margin-bottom: 30px; }
        .company-name { font-size: 22px; font-weight: bold; color: #1b4d3e; }
        .quote-title { font-size: 20px; font-weight: bold; text-align: right; color: #de7349; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { border-bottom: 2px solid #cbd5e1; text-align: left; padding: 10px; font-size: 11px; text-transform: uppercase; color: #64748b; }
        td { border-bottom: 1px solid #f1f5f9; padding: 12px 10px; }
        .totals { margin-top: 30px; float: right; width: 300px; }
        .totals-row { display: flex; justify-content: space-between; padding: 6px 0; }
        .grand-total { font-size: 16px; font-weight: bold; color: #1b4d3e; border-top: 2px solid #1b4d3e; padding-top: 8px; margin-top: 6px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div>
            <div class="company-name">{{ $settings['company_name'] }}</div>
            <div>{{ $settings['company_tagline'] }}</div>
            <div>{{ $settings['support_email'] }} | {{ $settings['support_phone'] }}</div>
        </div>
        <div>
            <div class="quote-title">PROFORMA QUOTATION</div>
            <div><strong>Ref:</strong> {{ $quotation->quotation_no }}</div>
            <div><strong>Date:</strong> {{ $quotation->quotation_date }}</div>
            <div><strong>Valid:</strong> {{ $quotation->valid_until ?: '15 Days' }}</div>
        </div>
    </div>

    <div style="margin-bottom: 25px;">
        <strong>PREPARED FOR:</strong><br>
        <span style="font-size: 15px; font-weight: bold;">{{ $quotation->customer_name }}</span><br>
        {{ $quotation->customer_email }} | {{ $quotation->customer_phone }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Item & Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Unit Price (INR)</th>
                <th style="text-align: right;">Total (INR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
                <tr>
                    <td><strong>{{ $item->item_name }}</strong></td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">₹{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;"><strong>₹{{ number_format($item->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-row">
            <span>Subtotal:</span>
            <span>₹{{ number_format($quotation->subtotal, 2) }}</span>
        </div>
        @if($quotation->discount_amount > 0)
            <div class="totals-row" style="color: #dc2626;">
                <span>Discount:</span>
                <span>- ₹{{ number_format($quotation->discount_amount, 2) }}</span>
            </div>
        @endif
        <div class="totals-row">
            <span>GST (18%):</span>
            <span>₹{{ number_format($quotation->tax_amount, 2) }}</span>
        </div>
        <div class="totals-row grand-total">
            <span>Grand Total:</span>
            <span>₹{{ number_format($quotation->grand_total, 2) }}</span>
        </div>
    </div>

    <div style="clear: both; margin-top: 50px; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 15px;">
        <strong>Terms & Conditions:</strong><br>
        {{ $quotation->terms ?: 'Standard 50% advance upon contract signing. Balance on completion.' }}
    </div>
</body>
</html>
