<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Enquiry Confirmation — {{ config('app.name', 'Hisab Mittra') }}</title>
<style>
  body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
  .wrapper { max-width:620px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.10); }

  /* Header */
  .header { background:linear-gradient(135deg,#047857 0%,#065f46 100%); padding:40px 40px 30px; text-align:center; }
  .header h1 { color:#fff; margin:0; font-size:24px; font-weight:700; }
  .header p  { color:#a7f3d0; margin:8px 0 0; font-size:14px; }

  /* Tick banner */
  .tick-banner { background:#e8f5e9; border-bottom:2px solid #a5d6a7; padding:18px 40px; text-align:center; }
  .tick-banner span { font-size:28px; }
  .tick-banner p { margin:6px 0 0; color:#2e7d32; font-size:15px; font-weight:600; }

  /* Body */
  .body { padding:36px 40px; }
  .greeting { font-size:16px; color:#111827; font-weight:600; margin:0 0 8px; }
  .intro    { font-size:14px; color:#374151; line-height:1.7; margin:0 0 28px; }

  /* Summary card */
  .card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:24px; margin-bottom:28px; }
  .card-title { font-size:12px; font-weight:700; color:#6b7280; letter-spacing:.8px; text-transform:uppercase; margin:0 0 16px; }
  table.details { width:100%; border-collapse:collapse; }
  table.details td { padding:8px 4px; vertical-align:top; }
  table.details td.lbl { width:38%; font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.6px; }
  table.details td.val { font-size:14px; color:#111827; }
  table.details tr:not(:last-child) td { border-bottom:1px solid #e2e8f0; }

  /* Message box */
  .msg-box { background:#fff; border:1px solid #e2e8f0; border-left:4px solid #2563b0;
             border-radius:0 8px 8px 0; padding:16px 18px; margin-top:18px; }
  .msg-box .lbl { font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.8px; margin-bottom:8px; }
  .msg-box p { margin:0; font-size:13px; color:#374151; line-height:1.7; white-space:pre-wrap; }

  /* What's next */
  .next { background:#eff6ff; border-radius:10px; padding:22px 24px; margin-bottom:28px; }
  .next h3 { margin:0 0 14px; font-size:14px; color:#1a3a6b; font-weight:700; }
  .step { display:flex; gap:12px; margin-bottom:10px; align-items:flex-start; }
  .step:last-child { margin-bottom:0; }
  .step-num { width:24px; height:24px; border-radius:50%; background:#2563b0; color:#fff;
              font-size:12px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .step-text { font-size:13px; color:#374151; line-height:1.6; padding-top:3px; }

  /* Contact info */
  .contact-strip { border:1px solid #e2e8f0; border-radius:10px; padding:18px 24px; margin-bottom:28px; }
  .contact-strip h3 { margin:0 0 12px; font-size:13px; color:#1a3a6b; font-weight:700; text-transform:uppercase; letter-spacing:.6px; }
  .c-row { display:flex; gap:10px; margin-bottom:8px; align-items:center; font-size:13px; color:#374151; }
  .c-row:last-child { margin-bottom:0; }
  .c-row a { color:#2563b0; text-decoration:none; }

  .ref { text-align:center; font-size:12px; color:#9ca3af; }

  /* Footer */
  .footer { background:#1a3a6b; padding:28px 40px; text-align:center; }
  .footer p { margin:0; font-size:12px; color:#bfd6f6; line-height:1.9; }
  .footer a { color:#90c2ff; text-decoration:none; }
  .footer .copy { font-size:11px; color:#6b8bb5; margin-top:12px; }
</style>
</head>
<body>
<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <h1>{{ config('app.name', 'Hisab Mittra') }}</h1>
    <p>Excellence in Enterprise Solutions</p>
  </div>

  <!-- Success banner -->
  <div class="tick-banner">
    <span>✅</span>
    <p>Your enquiry has been received successfully!</p>
  </div>

  <!-- Body -->
  <div class="body">

    <p class="greeting">Dear {{ $enquiry['firstname'] }},</p>
    <p class="intro">
      Thank you for reaching out to <strong>{{ config('app.name', 'Hisab Mittra') }}</strong>. We have received your enquiry
      and our team will get back to you within <strong>1–2 business days</strong>. We look forward to connecting with you.
    </p>

    <!-- Enquiry Summary -->
    <div class="card">
      <div class="card-title">Your Enquiry Summary</div>
      <table class="details">
        <tr>
          <td class="lbl">Reference ID</td>
          <td class="val"><strong>#ENQ-{{ str_pad($enquiry['id'], 5, '0', STR_PAD_LEFT) }}</strong></td>
        </tr>
        <tr>
          <td class="lbl">Full Name</td>
          <td class="val">{{ $enquiry['name'] }}</td>
        </tr>
        <tr>
          <td class="lbl">Email</td>
          <td class="val">{{ $enquiry['email'] }}</td>
        </tr>
        <tr>
          <td class="lbl">Phone</td>
          <td class="val">{{ $enquiry['phone'] }}</td>
        </tr>
        <tr>
          <td class="lbl">Submitted On</td>
          <td class="val">{{ now()->format('d M Y, h:i A') }}</td>
        </tr>
      </table>

      <div class="msg-box">
        <div class="lbl">Your Message</div>
        <p>{{ $enquiry['message'] }}</p>
      </div>
    </div>

    <!-- What's Next -->
    <div class="next">
      <h3>📋 What Happens Next?</h3>
      <div class="step">
        <div class="step-num">1</div>
        <div class="step-text">Our admissions team will review your enquiry carefully.</div>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <div class="step-text">A team member will contact you via email or phone within <strong>1–2 business days</strong>.</div>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-text">We may invite you for a school visit or orientation session if applicable.</div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="contact-strip">
      <h3>Need Immediate Assistance?</h3>
      <div class="c-row">📞 &nbsp;<a href="tel:+919783055170">+91 97830 55170</a></div>
      <div class="c-row">✉️ &nbsp;<a href="mailto:admin@hisabmittra.com">admin@hisabmittra.com</a></div>
      <div class="c-row">📍 &nbsp;India</div>
    </div>

    <p class="ref">
      Please keep your reference ID <strong>#ENQ-{{ str_pad($enquiry['id'], 5, '0', STR_PAD_LEFT) }}</strong>
      for any future communication.
    </p>

  </div>

  <!-- Footer -->
  <div class="footer">
    <p>
      <strong style="color:#fff;">{{ config('app.name', 'Hisab Mittra CRM') }}</strong><br/>
      <a href="tel:+919783055170">+91 97830 55170</a> &nbsp;|&nbsp;
      <a href="mailto:admin@hisabmittra.com">admin@hisabmittra.com</a><br/>
      <a href="{{ config('app.url', 'https://hisabmittra.com') }}">{{ config('app.url', 'https://hisabmittra.com') }}</a>
    </p>
    <p class="copy">
      © {{ date('Y') }} {{ config('app.name', 'Hisab Mittra') }}. All rights reserved.<br/>
      This is an automated confirmation email. Please do not reply directly.
    </p>
  </div>

</div>
</body>
</html>