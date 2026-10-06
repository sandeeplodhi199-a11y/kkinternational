    <style>
        :root {
            --kkis-primary: #10233f;
            --kkis-navy: #10233f;
            --kkis-gold: #ffd65a;
            --kkis-soft: #fff7e8;
        }
        .vs-menu-area,
        .sidemenu-content {
            background: linear-gradient(180deg, #ffffff 0%, #f4fbff 100%);
        }
        .vs-mobile-menu ul li a {
            font-weight: 700;
            color: var(--kkis-navy);
        }
        .sidemenu-content .widget_title,
        .sidemenu-content h3 {
            color: var(--kkis-navy);
        }
        .sidemenu-content .footer-logo img {
            max-width: 165px;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(16, 35, 63, 0.08);
        }
        .header-layout1 .header-top {
            background: linear-gradient(90deg, var(--kkis-navy), #173b69);
            border-bottom: 3px solid var(--kkis-gold);
        }
        .header-layout1 .header-top .header-links a,
        .header-layout1 .header-top .header-links li,
        .header-layout1 .header-top .header-links i {
            color: #ffffff !important;
        }
        .header-layout1 .sticky-active {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 35px rgba(16, 35, 63, 0.09);
        }
        .header-layout1 .sticky-active > .container {
            max-width: 1640px;
        }
        .header-layout1 .sticky-active .row {
            min-height: 92px;
        }
        .header-layout1 .header-logo {
            max-width: 150px;
            padding: 8px 0;
        }
        .header-layout1 .header-logo img {
            max-height: 78px;
            width: auto;
            border-radius: 12px;
        }
        .header-layout1 .main-menu > ul {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;
            flex-wrap: nowrap;
        }
        .header-layout1 .main-menu > ul > li {
            margin: 0 !important;
        }
        .header-layout1 .main-menu > ul > li > a {
            color: var(--kkis-navy);
            font-weight: 800;
            letter-spacing: 0.01em;
            font-size: 15px;
            line-height: 1.2;
            padding: 34px 0 !important;
            white-space: nowrap;
            text-transform: none !important;
        }
        .header-layout1 .main-menu a,
        .vs-mobile-menu a {
            text-transform: none !important;
        }
        .header-layout1 .main-menu > ul > li > a:hover {
            color: var(--kkis-primary);
        }
        .header-layout1 .main-menu ul.sub-menu {
            border: 0;
            border-radius: 18px;
            padding: 14px 0;
            box-shadow: 0 18px 45px rgba(16, 35, 63, 0.16);
        }
        .header-layout1 .main-menu ul.sub-menu li a {
            font-weight: 700;
            color: var(--kkis-navy);
            padding: 10px 24px;
        }
        .header-layout1 .main-menu ul.sub-menu li a:hover {
            color: var(--kkis-primary);
            background: #f3f8ff;
        }
        .header-layout1 .header-icons .simple-icon,
        .header-layout1 .vs-menu-toggle {
            color: var(--kkis-navy);
            background: var(--kkis-soft);
            border-radius: 14px;
        }
        .header-layout1 .vs-btn {
            background: linear-gradient(135deg, var(--kkis-primary), #173b69);
            color: #ffffff;
            box-shadow: 0 12px 26px rgba(16, 35, 63, 0.18);
        }
        .header-layout1 .vs-btn:hover {
            background: var(--kkis-navy);
            color: #ffffff;
        }
        .header-layout1 .simple-icon {
            width: 46px;
            height: 46px;
            line-height: 46px;
        }
        .header-layout1 .header-icons {
            display: none !important;
        }
        .header-layout1 .col-auto.d-none.d-lg-block {
            padding-left: 8px;
            padding-right: 8px;
        }
        .header-layout1 .col-auto.d-none.d-xl-block .vs-btn {
            padding: 17px 30px;
            border-radius: 999px;
        }
        .breadcumb-wrapper {
            position: relative;
            padding-top: 42px !important;
            padding-bottom: 42px !important;
            background:
                radial-gradient(circle at 12% 20%, rgba(255, 214, 90, 0.28) 0, rgba(255, 214, 90, 0.28) 90px, transparent 91px),
                radial-gradient(circle at 88% 18%, rgba(23, 59, 105, 0.12) 0, rgba(23, 59, 105, 0.12) 130px, transparent 131px),
                linear-gradient(135deg, #f4fbff 0%, #f4fbff 100%) !important;
            overflow: hidden;
        }
        .breadcumb-wrapper:before {
            content: "";
            position: absolute;
            inset: 14px 7.5%;
            border: 1px solid rgba(16, 35, 63, 0.07);
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.42);
            box-shadow: 0 24px 70px rgba(16, 35, 63, 0.08);
            pointer-events: none;
        }
        .breadcumb-wrapper:after {
            content: "";
            position: absolute;
            right: 8%;
            bottom: -80px;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: rgba(16, 35, 63, 0.06);
            pointer-events: none;
        }
        .breadcumb-wrapper .container {
            position: relative;
            z-index: 2;
        }
        .breadcumb-content {
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
        }
        .breadcumb-title {
            font-size: clamp(30px, 3.1vw, 44px) !important;
            line-height: 1.08 !important;
            margin: 0 !important;
            color: var(--kkis-navy) !important;
            letter-spacing: -0.03em;
        }
        .breadcumb-text {
            font-size: 15px !important;
            margin: 10px auto 0 auto !important;
            color: #46556a !important;
            max-width: 620px;
        }
        .breadcumb-menu-wrap {
            margin: 20px 0 0 0 !important;
            min-height: auto !important;
        }
        .breadcumb-menu {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: auto;
            max-width: 100%;
            padding: 10px 22px !important;
            border-radius: 999px !important;
            background: #ffffff !important;
            border: 1px solid rgba(16, 35, 63, 0.10);
            box-shadow: 0 14px 34px rgba(16, 35, 63, 0.10);
        }
        .breadcumb-menu:after {
            display: none !important;
        }
        .breadcumb-menu li,
        .breadcumb-menu a,
        .breadcumb-menu span {
            font-size: 13px !important;
            color: var(--kkis-navy) !important;
            font-weight: 800 !important;
        }
        .breadcumb-menu a {
            color: var(--kkis-primary) !important;
        }
        .breadcumb-menu li:not(:last-child):after {
            color: rgba(16, 35, 63, 0.35) !important;
            margin-left: 12px !important;
            margin-right: 9px !important;
        }
        .breadcumb-wrapper + .space,
        .breadcumb-wrapper + section.space,
        .breadcumb-wrapper + .space-top,
        .breadcumb-wrapper + section.space-top,
        .breadcumb-wrapper + .space-extra-bottom,
        .breadcumb-wrapper + section.space-extra-bottom {
            padding-top: 60px !important;
        }
        @media (max-width: 1399px) {
            .header-layout1 .sticky-active > .container {
                max-width: 1320px;
            }
            .header-layout1 .main-menu > ul {
                gap: 14px;
            }
            .header-layout1 .main-menu > ul > li > a {
                font-size: 13px;
            }
            .header-layout1 .col-auto.d-none.d-xl-block .vs-btn {
                padding: 15px 24px;
            }
        }
        @media (max-width: 1199px) {
            .header-layout1 .main-menu > ul {
                gap: 10px;
            }
            .header-layout1 .main-menu > ul > li > a {
                font-size: 12px;
            }
            .header-layout1 .col-auto.d-none.d-xl-block {
                display: none !important;
            }
        }
        @media (max-width: 991px) {
            .header-layout1 .sticky-active .row {
                min-height: 78px;
            }
            .breadcumb-wrapper {
                padding-top: 34px !important;
                padding-bottom: 34px !important;
            }
            .breadcumb-menu-wrap {
                margin-top: 16px !important;
            }
            .breadcumb-wrapper:before {
                inset: 10px;
                border-radius: 20px;
            }
            .breadcumb-wrapper + .space,
            .breadcumb-wrapper + section.space,
            .breadcumb-wrapper + .space-top,
            .breadcumb-wrapper + section.space-top,
            .breadcumb-wrapper + .space-extra-bottom,
            .breadcumb-wrapper + section.space-extra-bottom {
                padding-top: 34px !important;
            }
        }
    </style>

    <div class="vs-menu-wrapper">
        <div class="vs-menu-area text-center">
            <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}" alt="Kiddino"
                        style="width:150px; height:auto;">
                </a>
            </div>
            <div class="vs-mobile-menu">
                <ul>
                    <li>
                        <a href="{{ url('/') }}">Home</a>

                    </li>

                    <li class="menu-item-has-children">
                        <a href="#">About Us</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('about-us') }}">Welcome to KKIS</a></li>
                            <li><a href="{{ url('mission') }}">Vision & Mission</a></li>
                            <li><a href="{{ url('chairman-message') }}">Chairman's Message</a></li>
                            <li><a href="{{ url('board-of-directors') }}">Board of Directors</a></li>
                            <li><a href="{{ url('team') }}">Our Team</a></li>
                            <li><a href="{{ url('accomplishment') }}">Awards & Accolades</a></li>


                        </ul>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="#">Media</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('gallery') }}">Gallery</a></li>
                            <li><a href="{{ url('video') }}">Video</a></li>
                            <li><a href="{{ url('testimonial') }}">Testimonial</a></li>
                            <li><a href="{{ url('faq') }}">Frequently Asked Questions</a></li>
                            <li><a href="{{ url('blogs') }}">Blogs</a></li>


                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('events') }}">Events</a>

                    </li>
                    <li>
                        <a href="{{ url('academics') }}">Academics</a>

                    </li>

                    <li>
                        <a href="{{ url('facilities') }}">Facilities</a>

                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Programs</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('day-boarding-programs') }}">Day Boarding Program</a></li>
                            <li><a href="{{ url('hostel-program') }}">Hostel Program</a></li>
                            <li><a href="{{ url('kkis-yearly-program') }}">KKIS Yearly Program</a></li>
                            <li><a href="{{ url('sop-of-kkis') }}">SOP of KKIS</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('download') }}">Download</a>

                    </li>





                    <li>
                        <a href="{{ url('contact-us') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidemenu-wrapper d-none d-lg-block  ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="widget-about">
                    <div class="footer-logo"><img src="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}"
                            alt="Kiddino"></div>
                    <p class="mb-0">K. K. International School is dedicated to academic excellence, personal care and
                        holistic growth in a safe learning environment.</p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div>
                    <p class="footer-text">Monday to Friday: <span class="time">7:00 am - 5:30 pm</span></p>
                    <p class="footer-text">Saturday: <span class="time">Office timing may vary</span></p>
                    <p class="footer-info"><i class="fal fa-envelope"></i>Email: <a
                            href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></p>
                    <p class="footer-info"><i class="fas fa-mobile-alt"></i>Phone: <a href="tel:+97725525300">
                            +977-25-525300</a></p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Quick Links</h3>
                <div class="footer-menu">
                    <ul class="menu">
                        <li><a href="{{ url('about-us') }}">Welcome to KKIS</a></li>
                        <li><a href="{{ url('day-boarding-programs') }}">Day Boarding Program</a></li>
                        <li><a href="{{ url('academics') }}">Academics</a></li>
                        <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

   <!-- <div class="popup-search-box d-none d-lg-block  ">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="What are you looking for">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>  -->

    <header class="vs-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links style-white">
                            <ul>
                                <li><a href="{{ url('admin/dashboard') }}"><i class="far fa-user-circle"></i>Admin Login</a>
                                </li>
                                <!-- <li><a href="#" class="searchBoxTggler"><i class="far fa-search"></i>Search
                                        Keyword</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-auto text-center">
                        <div class="header-links style2 style-white">
                            <ul>
                                <li><i class="fas fa-envelope"></i>Email: <a href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></li>
                                <li><i class="fas fa-mobile-alt"></i>Phone: <a href="tel:+97725525300">
                                        +977-25-525300</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrap">
            <div class="sticky-active">
                <div class="container">
                    <div class="row gx-3 align-items-center justify-content-between">
                        <div class="col-8 col-sm-auto">
                            <div class="header-logo">
                                <a class="logo" href="{{ url('/') }}">
                                    <img src="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}" alt="Kiddino">
                                </a>
                            </div>
                        </div>
                        <div class="col text-end text-lg-center">
                            <nav class="main-menu menu-style1 d-none d-lg-block">
                                <ul>
                                    <li>
                                        <a href="{{ url('/') }}">Home</a>

                                    </li>

                                    <li class="menu-item-has-children">
                                        <a href="#">About Us</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('about-us') }}">Welcome to KKIS</a></li>
                                            <li><a href="{{ url('mission') }}">Vision & Mission</a></li>
                                            <li><a href="{{ url('chairman-message') }}">Chairman's Message</a></li>
                                            <li><a href="{{ url('board-of-directors') }}">Board of Directors</a></li>
                                            <li><a href="{{ url('team') }}">Our Team</a></li>
                                            <li><a href="{{ url('accomplishment') }}">Awards & Accolades</a></li>


                                        </ul>
                                    </li>

                                    <li class="menu-item-has-children">
                                        <a href="#">Media</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('gallery') }}">Gallery</a></li>
                                            <li><a href="{{ url('video') }}">Video</a></li>
                                            <li><a href="{{ url('testimonial') }}">Testimonial</a></li>
                                            <li><a href="{{ url('faq') }}">Frequently Asked Questions</a></li>
                                            <li><a href="{{ url('blogs') }}">Blogs</a></li>


                                        </ul>
                                    </li>

                                    <li>
                                        <a href="{{ url('events') }}">Events</a>

                                    </li>
                                    <li>
                                        <a href="{{ url('academics') }}">Academics</a>

                                    </li>
                                    <li>
                                        <a href="{{ url('facilities') }}">Facilities</a>

                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Programs</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('day-boarding-programs') }}">Day Boarding Program</a></li>
                                            <li><a href="{{ url('hostel-program') }}">Hostel Program</a></li>
                                            <li><a href="{{ url('kkis-yearly-program') }}">KKIS Yearly Program</a></li>
                                            <li><a href="{{ url('sop-of-kkis') }}">SOP of KKIS</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="{{ url('download') }}">Download</a>

                                    </li>





                                    <li>
                                        <a href="{{ url('contact-us') }}">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                            <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                        </div>
                        <div class="col-auto  d-none d-lg-block">
                            <div class="header-icons">
                                <button class="simple-icon sideMenuToggler"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <a href="{{ url('admission-procedures') }}" class="vs-btn">Admission</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
