<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>New Enquiry — KK International School</title>
<style>
  body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
  .wrapper { max-width:620px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.10); }
  .header { background:linear-gradient(135deg,#1a3a6b 0%,#2563b0 100%); padding:36px 40px; text-align:center; }
  .header img { height:64px; margin-bottom:14px; }
  .header h1 { color:#fff; margin:0; font-size:22px; font-weight:700; letter-spacing:.3px; }
  .header p  { color:#bfd6f6; margin:6px 0 0; font-size:13px; }
  .badge { display:inline-block; background:#f59e0b; color:#fff; font-size:11px; font-weight:700;
           letter-spacing:1px; text-transform:uppercase; padding:4px 12px; border-radius:20px; margin-top:10px; }
  .body { padding:36px 40px; }
  .intro { font-size:15px; color:#374151; margin:0 0 24px; line-height:1.6; }
  .card  { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:24px; margin-bottom:24px; }
  .row   { display:flex; gap:8px; margin-bottom:14px; align-items:flex-start; }
  .row:last-child { margin-bottom:0; }
  .icon  { width:36px; height:36px; border-radius:8px; background:#1a3a6b; display:flex; align-items:center;
           justify-content:center; flex-shrink:0; font-size:16px; }
  .info  { flex:1; }
  .label { font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.8px; margin-bottom:3px; }
  .value { font-size:15px; color:#111827; font-weight:500; }
  .msg-box { background:#fff; border:1px solid #e2e8f0; border-left:4px solid #2563b0;
             border-radius:0 8px 8px 0; padding:16px 18px; margin-top:20px; }
  .msg-box .label { margin-bottom:8px; }
  .msg-box p { margin:0; font-size:14px; color:#374151; line-height:1.7; white-space:pre-wrap; }
  .ref  { text-align:center; font-size:12px; color:#9ca3af; margin:20px 0 0; }
  .footer { background:#f8fafc; border-top:1px solid #e2e8f0; padding:24px 40px; text-align:center; }
  .footer p { margin:0; font-size:12px; color:#6b7280; line-height:1.8; }
  .footer a { color:#2563b0; text-decoration:none; }
  .divider { height:1px; background:#e2e8f0; margin:24px 0; }
</style>
</head>
<body>
<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <img src="https://kkinternationalschool.org/public/uploads/202606011816kk_logo.jpeg" alt="KK International School Logo" />
    <h1>New Enquiry Received</h1>
    <p>An enquiry has been submitted via the website contact form</p>
    <span class="badge">🔔 Action Required</span>
  </div>

  <!-- Body -->
  <div class="body">
    <p class="intro">
      Hello Admin, a new enquiry has been submitted on <strong>{{ now()->format('d M Y, h:i A') }}</strong>.
      Please review the details below and respond promptly.
    </p>

    <div class="card">

      <div class="row">
        <div class="icon">👤</div>
        <div class="info">
          <div class="label">Full Name</div>
          <div class="value">{{ $enquiry['name'] }}</div>
        </div>
      </div>

      <div class="row">
        <div class="icon">✉️</div>
        <div class="info">
          <div class="label">Email Address</div>
          <div class="value"><a href="mailto:{{ $enquiry['email'] }}" style="color:#2563b0;text-decoration:none;">{{ $enquiry['email'] }}</a></div>
        </div>
      </div>

      <div class="row">
        <div class="icon">📞</div>
        <div class="info">
          <div class="label">Phone Number</div>
          <div class="value"><a href="tel:{{ $enquiry['phone'] }}" style="color:#2563b0;text-decoration:none;">{{ $enquiry['phone'] }}</a></div>
        </div>
      </div>

      <div class="msg-box">
        <div class="label">Message</div>
        <p>{{ $enquiry['message'] }}</p>
      </div>

    </div>

    <p class="ref">Enquiry Reference ID: <strong>#ENQ-{{ str_pad($enquiry['id'], 5, '0', STR_PAD_LEFT) }}</strong></p>

    <div class="divider"></div>

    <p style="font-size:13px;color:#6b7280;text-align:center;margin:0;">
      Please reply to the applicant within <strong>24 hours</strong> to ensure the best experience.
    </p>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>
      <strong>KK International School</strong><br/>
      📍 Dharan, Sunsari, Nepal &nbsp;|&nbsp;
      📞 <a href="tel:+977-25-525300">+977-25-525300</a> &nbsp;|&nbsp;
      ✉️ <a href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a>
    </p>
    <p style="margin-top:10px;font-size:11px;color:#9ca3af;">
      This is an automated notification. Do not reply to this email directly.
    </p>
  </div>

</div>
</body>
</html>