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
        <!-- 1. Left: EXACT Crisp Vector QR Code Block (Matching user uploaded reference) -->
            <div class="quotation-qr-col" style="flex: 0 0 165px; width: 165px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: flex-start;">
                <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 900; color: #0b192c; letter-spacing: 0.2px; line-height: 1.2; text-align: center;">HISABMITTRA</div>
                <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 11.5px; font-weight: 700; color: #0b192c; margin-top: 2px; line-height: 1.2; text-align: center;">
                    UPI ID: <span style="color: #b91c1c; font-weight: 800;">hisabmitra@idfcbank</span>
                </div>
                <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 8px; font-weight: 600; color: #1e293b; margin-top: 2px; line-height: 1.2; text-align: center; letter-spacing: -0.1px;">
                    Scan this QR code with any UPI app to transfer
                </div>
                <div style="margin: 4px auto; width: 125px; height: 125px; display: flex; align-items: center; justify-content: center;">
                    <img src="/crm/images/hisab-mittra-qr.png" alt="HisabMittra UPI QR" class="quotation-qr-img" style="width: 125px; height: 125px; display: block; object-fit: contain; margin: 0 auto;">
                </div>
                <div style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; background-color: #991b24; color: #ffffff; padding: 3px 9px; border-radius: 3px; margin: 0 auto; box-sizing: border-box;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0; display: block;">
                        <rect x="2" y="2" width="20" height="20" rx="1.5" stroke="white" stroke-width="2.2"/>
                        <line x1="6" y1="7" x2="18.5" y2="7" stroke="white" stroke-width="2.2" stroke-linecap="square"/>
                        <line x1="6" y1="12" x2="15" y2="12" stroke="white" stroke-width="2.2" stroke-linecap="square"/>
                        <rect x="6" y="15.5" width="2.5" height="2.5" fill="white"/>
                    </svg>
                    <div style="text-align: left; line-height: 1.15; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                        <div style="font-size: 9.5px; font-weight: 900; letter-spacing: 0.2px; color: #ffffff; white-space: nowrap;">IDFC FIRST</div>
                        <div style="font-size: 8px; font-weight: 700; color: #ffffff; white-space: nowrap;">Bank</div>
                    </div>
                </div>
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
            <img src="/crm/images/hisab-mittra-seal-sign-exact.png" alt="For HISABMITTRA - Authorized Signatory" style="width: 195px; height: auto; max-height: 140px; display: block; margin: 0 auto; ">
        </div>
    </div>

</body>
</html>


