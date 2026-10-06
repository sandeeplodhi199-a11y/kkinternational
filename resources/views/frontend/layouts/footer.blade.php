 <style>
     .footer-layout1.kkis-footer {
         background: linear-gradient(180deg, #10233f 0%, #081528 100%) !important;
         color: rgba(255, 255, 255, 0.82);
     }
     .kkis-footer .footer-top {
         background: linear-gradient(135deg, #10233f, #173b69);
         border-radius: 0 0 34px 34px;
         box-shadow: 0 18px 45px rgba(16, 35, 63, 0.18);
     }
     .kkis-footer .footer-top img[alt="logo"] {
         background: #fff;
         border-radius: 16px;
         padding: 8px;
         box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
     }
     .kkis-footer .widget-area {
         padding-top: 78px;
     }
     .kkis-footer .footer-widget {
         background: rgba(255, 255, 255, 0.06);
         border: 1px solid rgba(255, 255, 255, 0.10);
         border-radius: 24px;
         padding: 30px;
         height: 100%;
     }
     .kkis-footer .footer-widget h3,
     .kkis-footer .footer-widget .widget_title {
         color: #ffffff;
     }
     .kkis-footer .footer-widget p,
     .kkis-footer .footer-widget a,
     .kkis-footer .footer-text,
     .kkis-footer .footer-info {
         color: rgba(255, 255, 255, 0.82);
     }
     .kkis-footer .footer-widget a:hover {
         color: #ffd65a;
     }
     .kkis-footer .footer-menu a,
     .kkis-footer .copyright-text a {
         text-transform: none !important;
     }
     .kkis-footer .footer-info i {
         background: #ffd65a;
         color: #10233f;
     }
     .kkis-footer .footer-menu a:before {
         background-color: #ffd65a !important;
     }
     .kkis-footer .footer-social a {
         background: rgba(255, 255, 255, 0.10);
         color: #ffffff;
     }
     .kkis-footer .footer-social a:hover {
         background: #ffd65a;
         color: #10233f;
     }
     .kkis-footer .copyright-wrap {
         background: rgba(0, 0, 0, 0.18);
         border-top: 1px solid rgba(255, 255, 255, 0.08);
     }
     .kkis-footer .copyright-text,
     .kkis-footer .copyright-text a {
         color: rgba(255, 255, 255, 0.78);
     }
     .kkis-footer .copyright-text a:hover {
         color: #ffd65a;
     }
     .kkis-footer .footer-menu .menu {
         display: flex;
         flex-direction: column;
         gap: 10px;
         margin: 0;
         padding: 0;
         list-style: none;
     }
     .kkis-footer .footer-menu .menu li {
         margin: 0;
     }
     .kkis-footer .footer-menu .menu a {
         display: block;
         position: relative;
         padding-left: 22px;
         font-size: 16px;
         line-height: 1.35;
         white-space: normal;
     }
     .kkis-footer .footer-menu .menu a:before {
         left: 0;
         top: 0.62em;
     }
     .kkis-footer .footer-contact-block {
         margin-top: 22px;
         padding-top: 22px;
         border-top: 1px solid rgba(255, 255, 255, 0.12);
     }
 </style>

 <footer class="footer-wrapper footer-layout1 kkis-footer">
     <div class="footer-top">
         <div class="container">
             <div class="row gx-60 gy-4 text-center text-lg-start justify-content-between align-items-center">
                 <div class="col-lg"> <a href="{{ url('/') }}">
                         <img src="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}" alt="logo"
                             style="width:140px; height:auto; object-fit:contain; display:block;">
                     </a></div>
                 <div class="col-lg-auto">
                     <h3 class="h4 mb-0 text-white"><img src="{{ url('assets/frontend/img/icon/check-list.svg') }}"
                             alt="icon" class="me-2"> Begin your child's KKIS journey today</h3>
                 </div>
                 <div class="col-lg-auto"><a href="{{ url('admission-procedures') }}" class="vs-btn">Admission Enquiry</a></div>
             </div>
         </div>
     </div>
     <div class="widget-area">
         <div class="container">
             <div class="row justify-content-center gx-40 gy-4">
                 <div class="col-lg-4">
                     <div class="widget footer-widget">
                         <div class="widget-about">
                             <h3 class="mt-n2">Learning Today for a Better Tomorrow</h3>
                             <p class="map-link"><img src="{{ url('assets/frontend/img/icon/map.svg') }}" alt="svg">
                                 Dharan, Sunsari, Nepal
                             </p>
                             <p>K. K. International School nurtures academic excellence, confidence and holistic growth
                                 in a safe and caring environment.</p>
                             <div class="footer-contact-block">
                                 <h3 class="widget_title">Get In Touch</h3>
                                 <p class="footer-text">Monday to Friday: <span class="time">7:00 am - 5:30 pm</span></p>
                                 <p class="footer-text">Saturday: <span class="time">Office timing may vary</span></p>
                                 <p class="footer-info"><i class="fal fa-envelope"></i>Email: <a
                                         href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></p>
                                 <p class="footer-info"><i class="fas fa-mobile-alt"></i>Phone: <a
                                         href="tel:+97725525300">+977-25-525300</a></p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-4">
                     <div class="widget widget_nav_menu footer-widget">
                         <h3 class="widget_title">Useful Links</h3>
                         <div class="menu-all-pages-container footer-menu">
                             <ul class="menu">
                                 <li><a href="{{ url('/') }}">Home</a></li>
                                 <li><a href="{{ url('about-us') }}">Welcome to KKIS</a></li>
                                 <li><a href="{{ url('mission') }}">Vision & Mission</a></li>
                                 <li><a href="{{ url('chairman-message') }}">Chairman's Message</a></li>
                                 <li><a href="{{ url('board-of-directors') }}">Board of Directors</a></li>
                                 <li><a href="{{ url('team') }}">Our Team</a></li>
                                 <li><a href="{{ url('accomplishment') }}">Awards & Accolades</a></li>
                                 <li><a href="{{ url('events') }}">Events</a></li>
                                 <li><a href="{{ url('academics') }}">Academics</a></li>
                                 <li><a href="{{ url('facilities') }}">Facilities</a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-4">
                     <div class="widget widget_nav_menu footer-widget">
                         <h3 class="widget_title">Useful Links</h3>
                         <div class="menu-all-pages-container footer-menu">
                             <ul class="menu">
                                 <li><a href="{{ url('gallery') }}">Gallery</a></li>
                                 <li><a href="{{ url('video') }}">Video</a></li>
                                 <li><a href="{{ url('testimonial') }}">Testimonial</a></li>
                                 <li><a href="{{ url('faq') }}">Frequently Asked Questions</a></li>
                                 <li><a href="{{ url('blogs') }}">Blogs</a></li>
                                 <li><a href="{{ url('day-boarding-programs') }}">Day Boarding Program</a></li>
                                 <li><a href="{{ url('hostel-program') }}">Hostel Program</a></li>
                                 <li><a href="{{ url('kkis-yearly-program') }}">KKIS Yearly Program</a></li>
                                 <li><a href="{{ url('sop-of-kkis') }}">SOP of KKIS</a></li>
                                 <li><a href="{{ url('download') }}">Download</a></li>
                                 <li><a href="{{ url('admission-procedures') }}">Admission</a></li>
                                 <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="copyright-wrap">
         <div class="container">
             <div class="row flex-row-reverse gy-3 justify-content-between align-items-center">
                 <div class="col-lg-auto">
                     @php
                         $normalizeSocialUrl = function ($url) {
                             $url = trim((string) $url);
                             if ($url === '') {
                                 return '';
                             }
                             if (preg_match('/^(https?:\/\/|mailto:|tel:)/i', $url)) {
                                 return $url;
                             }
                             return 'https://' . ltrim($url, '/');
                         };
                         $socialLinks = [
                             ['url' => $normalizeSocialUrl($socialSetting->facebook ?? ''), 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
                             ['url' => $normalizeSocialUrl($socialSetting->instagram ?? ''), 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
                             ['url' => $normalizeSocialUrl($socialSetting->twitter ?? ''), 'icon' => 'fab fa-twitter', 'label' => 'Twitter'],
                             ['url' => $normalizeSocialUrl($socialSetting->linkdin ?? ''), 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
                             ['url' => $normalizeSocialUrl($socialSetting->youtube ?? ''), 'icon' => 'fab fa-youtube', 'label' => 'YouTube'],
                             ['url' => $normalizeSocialUrl($socialSetting->whatsapp ?? ''), 'icon' => 'fab fa-whatsapp', 'label' => 'WhatsApp'],
                         ];
                     @endphp
                     <div class="footer-social">
                         @foreach ($socialLinks as $social)
                             @if (!empty($social['url']))
                                 <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                                     <i class="{{ $social['icon'] }}"></i>
                                 </a>
                             @endif
                         @endforeach
                     </div>
                 </div>

                 <div class="col-lg-auto">
                     <p class="copyright-text">
                         Copyright &copy; <?php echo date("Y"); ?>
                         <a href="{{ url('/') }}">KK International School</a>.
                         All Rights Reserved
                         |
                         <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                         |
                         <a href="{{ url('term-condition') }}">Terms & Conditions</a>
                         |
                         <a href="{{ url('cancellation-refund') }}">Cancellation & Refund</a>
                     </p>
                 </div>
             </div>
         </div>
     </div>
 </footer> <!-- Scroll To Top -->
 <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>
