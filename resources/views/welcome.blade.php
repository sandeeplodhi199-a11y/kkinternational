<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>K.K. International School | Premium Maintenance</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, 'Inter', sans-serif;
      background: #0f1a24;
      scroll-behavior: smooth;
    }

   
    body {
      background-image: url('public/kkin.jpeg');
      background-size: cover;
      background-position: center 30%;
      background-attachment: fixed;
      background-repeat: no-repeat;
      position: relative;
    }

    /* dark premium overlay to make text readable and give rich contrast */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 30% 20%, rgba(0, 0, 0, 0.45) 0%, rgba(0, 15, 35, 0.8) 100%);
      pointer-events: none;
      z-index: 0;
    }

    /* subtle grain texture for premium feel */
    body::after {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('public/kkin.jpeg');
      background-repeat: repeat;
      pointer-events: none;
      z-index: 0;
    }

    /* main container to hold both sections above background */
    .page-wrapper {
      position: relative;
      z-index: 2;
    }

    /* ========== SECTION 1: PREMIUM UNDER MAINTENANCE BANNER ========== */
    .maintenance-banner {
      min-height: 85vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 1.5rem;
      position: relative;
    }

   .banner-card {
    max-width: 746px;
    width: 100%;
    background: rgba(10, 22, 35, 0.72);
    backdrop-filter: blur(0px);
    -webkit-backdrop-filter: blur(18px);
    border-radius: 8rem;
    border: 1px solid rgba(255, 215, 0, 0.5);
    box-shadow: 0 45px 75px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 210, 80, 0.25) inset;
    padding: 1rem 1rem;
    text-align: center;
    transition: all 0.3s ease;
    animation: gentleFloat 6s infinite alternate;
    /* margin-top: -93px; */
}

    @keyframes gentleFloat {
      0% {
        transform: translateY(0px);
        box-shadow: 0 45px 75px rgba(0, 0, 0, 0.4);
      }
      100% {
        transform: translateY(-10px);
        box-shadow: 0 60px 90px rgba(0, 0, 0, 0.6);
      }
    }

    .school-badge {
      margin-bottom: 1rem;
    }

    .school-name {
      font-size: 2.3rem;
      font-weight: 800;
      letter-spacing: 3.5px;
      background: linear-gradient(135deg, #FFF6D0, #FFE89F, #FECB4E);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      text-transform: uppercase;
      margin-bottom: 0.3rem;
    }

    .school-location {
      font-size: 0.75rem;
      letter-spacing: 2px;
      color: rgba(255, 240, 180, 0.9);
      border-top: 1px dashed rgba(255, 200, 80, 0.6);
      display: inline-block;
      padding-top: 0.5rem;
    }

   
  

    .main-title {
      font-size: 2.8rem;
      font-weight: 800;
      margin: 0.4rem 0;
      background: linear-gradient(120deg, #FFFFFF, #FFEAA8, #FCCF5E);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      letter-spacing: -0.5px;
      text-transform: uppercase;
    }

    .gold-divider {
      width: 110px;
      height: 3px;
      background: linear-gradient(90deg, #FFD966, #FFB347, #FFD966);
      margin: 1.2rem auto;
      border-radius: 4px;
    }

    .message {
      font-size: 1.2rem;
      line-height: 1.55;
      color: #f0f4fc;
      max-width: 580px;
      margin: 1rem auto;
    }

    .highlight {
      color: #FFE396;
      font-weight: 600;
      background: rgba(0, 0, 0, 0.4);
      padding: 0 8px;
      border-radius: 12px;
    }

    .upgrade-note {
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      display: inline-block;
      padding: 0.5rem 1.4rem;
      border-radius: 60px;
      font-size: 0.85rem;
      color: #FFECB3;
      border-left: 2px solid #f5b042;
      border-right: 2px solid #f5b042;
      margin: 0.8rem 0;
    }

    .eta-wrapper {
      background: rgba(0, 10, 20, 0.6);
      backdrop-filter: blur(8px);
      border-radius: 80px;
      display: inline-flex;
      align-items: center;
      gap: 0.9rem;
      padding: 0.5rem 1.6rem;
      margin: 0.8rem 0 1rem;
      border: 1px solid rgba(255, 200, 80, 0.55);
    }

    .eta-text {
      font-weight: 500;
      font-size: 0.85rem;
    }

    .eta-value {
      font-weight: 800;
      color: #FFE28A;
    }

    .contact-micro {
      margin-top: 1.4rem;
      padding-top: 1rem;
      border-top: 1px solid rgba(255, 210, 90, 0.35);
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.6rem;
      font-size: 0.85rem;
      color: #e0eaff;
    }

    .contact-micro a {
      color: #FFDE8A;
      text-decoration: none;
      border-bottom: 1px dotted transparent;
      transition: 0.2s;
    }

    .contact-micro a:hover {
      color: #FFF5CC;
      border-bottom-color: #FFD966;
    }

    .launch-soon {
      margin-top: 1rem;
      display: inline-block;
      background: rgba(255, 195, 70, 0.15);
      border-radius: 60px;
      padding: 0.3rem 1.3rem;
      font-size: 0.75rem;
      font-weight: 500;
      letter-spacing: 1.5px;
      color: #FFE5AA;
    }

   .vision-section {
    padding: 2rem 2rem;
    position: relative;
    background: rgb(255 243 213);
    backdrop-filter: blur(2px);
    margin-top: 1rem;
    border-top-left-radius: 3rem;
    border-top-right-radius: 3rem;
    box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
}

    .container {
      max-width: 1300px;
      margin: 0 auto;
    }

    .section-header {
      text-align: center;
      margin-bottom: 3.5rem;
    }

    .section-header h2 {
      font-size: 2.8rem;
      font-weight: 800;
      background: linear-gradient(125deg, #1F3A5F, #2C5A7A, #B96F1E);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      letter-spacing: -0.3px;
      margin-bottom: 0.8rem;
      text-transform: uppercase;
    }

    .gold-line {
      width: 100px;
      height: 4px;
      background: linear-gradient(90deg, #E6B03D, #FFD966, #E6B03D);
      margin: 0 auto;
      border-radius: 4px;
    }

    .subhead {
    color: #000000;
    font-size: 1.1rem;
    margin-top: 1rem;
    font-weight: 400;
}

    .vision-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
      margin-top: 1rem;
    }

    .vision-card {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(2px);
      padding: 2rem 1.8rem;
      border-radius: 2rem;
      text-align: center;
      box-shadow: 0 25px 40px -14px rgba(0, 0, 0, 0.12);
      transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      border: 1px solid rgba(230, 176, 61, 0.3);
      position: relative;
      overflow: hidden;
    }

    .vision-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #E6B03D, #FFD966, #E6B03D);
      transform: scaleX(0);
      transition: transform 0.4s ease;
      transform-origin: left;
    }

    .vision-card:hover::before {
      transform: scaleX(1);
    }

    .vision-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 35px 50px -18px rgba(0, 0, 0, 0.2);
      border-color: #FFD966;
    }

    .card-icon {
      font-size: 2.8rem;
      margin-bottom: 0.8rem;
      display: inline-block;
    }

    .vision-card h3 {
      font-size: 1.7rem;
      font-weight: 700;
      color: #1a3f5c;
      margin-bottom: 1rem;
      letter-spacing: -0.2px;
    }

    .vision-card p {
      color: #2c4a6e;
      font-size: 1rem;
      line-height: 1.5;
      font-weight: 400;
    }

    /* simple footer (no menu) */
    .simple-footer {
      background: rgba(8, 18, 28, 0.9);
      backdrop-filter: blur(8px);
      text-align: center;
      padding: 1.8rem;
      color: #cadeff;
      font-size: 0.8rem;
      border-top: 1px solid rgba(255, 215, 0, 0.2);
      margin-top: 0;
    }

    /* responsiveness */
    @media (max-width: 750px) {
      .banner-card {
        padding: 2rem 1.2rem;
      }
      .main-title {
        font-size: 2.3rem;
      }
      .school-name {
        font-size: 1.5rem;
      }
      .message {
        font-size: 1rem;
      }
      .section-header h2 {
        font-size: 2rem;
      }
      .vision-card h3 {
        font-size: 1.4rem;
      }
      .vision-grid {
        gap: 1.3rem;
      }
      .vision-section {
        padding: 3rem 1.2rem;
      }
    }

    /* ensure no navbar or extra menus */
    .navbar, .nav-links, .login-btn, nav, .menu, .footer-menu, .buttons {
      display: none !important;
    }
  </style>
</head>
<body>
<div class="page-wrapper">
  <!-- ========== SECTION 1: UNDER MAINTENANCE BANNER ========== -->
  <section class="maintenance-banner">
    <div class="banner-card">
      <div class="school-badge">
        <div class="school-name">K.K. INTERNATIONAL SCHOOL</div>
        <div class="school-location">DHARAN - 15 | SUNSARI | NEPAL</div>
      </div>
     
      <h1 class="main-title">WEBSITE UNDER MAINTENANCE</h1>
      <div class="gold-divider"></div>
      <!--<div class="message">-->
      <!--  We're crafting a <span class="highlight">state-of-the-art digital ecosystem</span> with enhanced performance.<br>-->
      <!--  Our platform is being upgraded for a seamless, smarter experience.-->
      <!--</div>-->
      <!--<div class="upgrade-note">-->
      <!--  🚀 New Portal · Speed Optimized · Refined Interface-->
      <!--</div>-->
      <!--<div class="eta-wrapper">-->
      <!--  <span class="eta-text">⏳ EXPECTED COMPLETION</span>-->
      <!--  <span class="eta-value" id="dynamicEta">within 48 hours</span>-->
      <!--  <span class="eta-text">✨</span>-->
      <!--</div>-->
      <div class="contact-micro">
        <span>📞 +977-25-525300</span>
        <span>✉️ <a href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></span>
        <span>📍 Dharan, Sunsari, Nepal</span>
      </div>
      <div class="launch-soon">
        ✦ NEW WEBSITE LAUNCHING SOON ✦
      </div>
    </div>
  </section>

  <!-- ========== SECTION 2: OUR VISION & LEADERSHIP (PREMIUM PROFESSIONAL) ========== -->
  <section class="vision-section">
    <div class="container">
      <div class="section-header">
        <h2>Our Vision & Leadership</h2>
        <div class="gold-line"></div>
        <div class="subhead">Guided by integrity, driven by excellence — shaping global citizens</div>
      </div>
      <div class="vision-grid">
        <div class="vision-card">
          <div class="card-icon">👨‍🎓</div>
          <h3>Chairman's Message</h3>
          <p>Leading the institution towards excellence and global vision, fostering innovation with purpose.</p>
        </div>
        <div class="vision-card">
          <div class="card-icon">📚</div>
          <h3>Principal's Message</h3>
          <p>Dedicated to shaping future leaders with quality education, empathy, and academic rigor.</p>
        </div>
        <div class="vision-card">
          <div class="card-icon">🌍</div>
          <h3>Mission</h3>
          <p>Providing holistic education for lifelong success, empowering minds to transcend boundaries.</p>
        </div>
        <div class="vision-card">
          <div class="card-icon">🎯</div>
          <h3>Goal</h3>
          <p>Empowering students with knowledge, values, and critical thinking for a changing world.</p>
        </div>
        <div class="vision-card">
          <div class="card-icon">⚖️</div>
          <h3>Oath</h3>
          <p>Commitment to discipline, integrity, and excellence — upholding our core ethos.</p>
        </div>
        <div class="vision-card">
          <div class="card-icon">🏆</div>
          <h3>Accomplishments</h3>
          <p>Recognized achievements in academics, co-curricular brilliance, and community impact.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- minimal footer (no navigation, only copyright) -->
  <div class="simple-footer">
    <p>K.K. International School — Dharan, Sunsari, Nepal | Excellence in Education since 1995</p>
    <p style="margin-top: 6px; opacity:0.7;">All rights reserved.</p>
  </div>
</div>

<script>
  (function() {
    // Dynamic ETA for maintenance banner
    const etaSpan = document.getElementById('dynamicEta');
    if (etaSpan) {
      function updateMaintenanceETA() {
        const now = new Date();
        const day = now.getDay(); // 0 = Sunday, 6 = Saturday
        const hour = now.getHours();
        let etaMsg = "within 48 hours";
        
        if (day === 0) etaMsg = "by Monday morning";
        else if (day === 6) etaMsg = "by Sunday evening";
        else if (day === 5 && hour >= 15) etaMsg = "early next week";
        else if (hour >= 22 || hour <= 5) etaMsg = "tomorrow morning";
        else if (hour >= 8 && hour < 12) etaMsg = "later today";
        else if (hour >= 12 && hour < 18) etaMsg = "within 24 hours";
        else etaMsg = "very soon — stay tuned";
        
        etaSpan.innerText = etaMsg;
      }
      updateMaintenanceETA();
      setInterval(updateMaintenanceETA, 1800000);
    }

    // subtle interactive hover effect for vision cards (already in CSS)
    // ensure no stray navbar appears
    const unwantedSelectors = ['.navbar', '.nav-links', '.login-btn', '.menu', '.buttons', 'header:not(.page-wrapper)'];
    unwantedSelectors.forEach(sel => {
      document.querySelectorAll(sel).forEach(el => {
        if (el && !el.closest('.banner-card') && !el.closest('.vision-section')) {
          el.style.display = 'none';
        }
      });
    });
    
    // additional check: remove any element containing admission/program links that might be leftover
    const allLinks = document.querySelectorAll('a');
    allLinks.forEach(link => {
      const linkText = link.innerText.toLowerCase();
      if ((linkText.includes('admission') || linkText.includes('program') || linkText.includes('about') || linkText.includes('login')) && !link.closest('.contact-micro')) {
        if (!link.closest('.banner-card')) {
          link.style.display = 'none';
        }
      }
    });
  })();
</script>
</body>
</html>