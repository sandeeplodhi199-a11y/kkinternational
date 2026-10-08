<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation {{ $quotation->quotation_no }}</title>
    <style>
        body { font-family: sans-serif; color: #1e293b; font-size: 12px; margin: 0; padding: 20px; }
        .header { width: 100%; border-bottom: 2px solid #1b4d3e; padding-bottom: 15px; margin-bottom: 25px; }
        .title { font-size: 20px; font-weight: bold; color: #1b4d3e; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { border-bottom: 2px solid #cbd5e1; text-align: left; padding: 8px; font-size: 10px; text-transform: uppercase; color: #64748b; }
        td { border-bottom: 1px solid #f1f5f9; padding: 10px 8px; }
        .totals { width: 40%; float: right; margin-top: 25px; }
        .totals table td { border: none; padding: 4px 8px; }
        .grand { font-size: 14px; font-weight: bold; color: #1b4d3e; border-top: 2px solid #1b4d3e !important; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td style="border:none;">
                <div class="title">{{ $settings['company_name'] }}</div>
                <div>{{ $settings['company_tagline'] }}</div>
                <div>{{ $settings['support_email'] }} | {{ $settings['support_phone'] }}</div>
            </td>
            <td style="border:none; text-align: right;">
                <div style="font-size: 16px; font-weight: bold; color: #de7349;">QUOTATION</div>
                <div><strong>Ref:</strong> {{ $quotation->quotation_no }}</div>
                <div><strong>Date:</strong> {{ $quotation->quotation_date }}</div>
                <div><strong>Valid:</strong> {{ $quotation->valid_until ?: '15 Days' }}</div>
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        <strong>PREPARED FOR:</strong><br>
        <span style="font-size: 14px; font-weight: bold;">{{ $quotation->customer_name }}</span><br>
        {{ $quotation->customer_email }} | {{ $quotation->customer_phone }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
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
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;"><strong>{{ number_format($item->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">{{ number_format($quotation->subtotal, 2) }}</td>
            </tr>
            @if($quotation->discount_amount > 0)
                <tr style="color: #dc2626;">
                    <td>Discount:</td>
                    <td style="text-align: right;">- {{ number_format($quotation->discount_amount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>GST (18%):</td>
                <td style="text-align: right;">{{ number_format($quotation->tax_amount, 2) }}</td>
            </tr>
            <tr class="grand">
                <td>Grand Total:</td>
                <td style="text-align: right;">INR {{ number_format($quotation->grand_total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both; margin-top: 40px; font-size: 10px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 10px;">
        <strong>Terms & Conditions:</strong><br>
        {{ $quotation->terms ?: 'Payment due within 15 days of invoice date.' }}
    </div>

    <!-- EXACT FOOTER: Bank Details & QR (Left/Middle) + Seal & Signature (Right) -->
    <div style="clear: both; margin-top: 30px; border-top: 2px solid #1e3a8a; padding-top: 15px; display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; page-break-inside: avoid; break-inside: avoid;">
        <!-- 1. Left: EXACT QR Code Block -->
        <div style="width: 150px; text-align: center; flex: 0 0 150px;">
            <img src="/crm/images/hisab-mittra-qr-col.png?v=2" alt="HisabMittra UPI QR" style="width: 145px; height: auto; display: block; margin: 0 auto; image-rendering: -webkit-optimize-contrast;">
        </div>

        <!-- 2. Middle: Bank Details (Matching user uploaded reference) -->
        <div style="flex: 1 1 auto; padding: 0 10px; font-size: 11px; line-height: 1.55; color: #1e293b;">
            <div style="font-weight: 800; font-size: 12px; color: #0f172a; margin-bottom: 4px;">Bank Details:</div>
            <table style="width: 100%; border-collapse: collapse; font-size: 11px; line-height: 1.55;">
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; width: 85px; font-weight: 500;">Company:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">HISABMITTRA</td></tr>
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; font-weight: 500;">Bank:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">IDFC FIRST Bank</td></tr>
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; font-weight: 500;">Account #:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">10296073180</td></tr>
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; font-weight: 500;">IFSC Code:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">IDFB0043413</td></tr>
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; font-weight: 500;">SWIFT Code:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">IDFBINBBMUM</td></tr>
                <tr><td style="color: #64748b; padding: 1.5px 8px 1.5px 0; font-weight: 500;">Branch:</td><td style="font-weight: 700; color: #0f172a; padding: 1.5px 0;">JAIPUR - PRATAP NAGAR BRANCH</td></tr>
            </table>
        </div>

        <!-- 3. Right: EXACT Official Seal & Signature -->
        <div style="width: 210px; text-align: center; flex: 0 0 210px;">
            <img src="/crm/images/hisab-mittra-seal-sign-exact.png" alt="For HISABMITTRA - Authorized Signatory" style="width: 195px; height: auto; max-height: 140px; display: block; margin: 0 auto; image-rendering: -webkit-optimize-contrast;">
        </div>
    </div>

</body>
</html>
