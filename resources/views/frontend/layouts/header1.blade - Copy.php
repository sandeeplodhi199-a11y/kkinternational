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
                        <a href="#">Home</a>

                    </li>

                    <li class="menu-item-has-children">
                        <a href="#">About Us</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('about-us') }}">About us</a></li>
                            <li><a href="{{ url('team') }}">Team</a></li>
                            <li><a href="{{ url('goal') }}">Goal</a></li>
                            <li><a href="{{ url('mission') }}">Mission</a></li>
                            <li><a href="{{ url('director-message') }}">Director Message</a></li>
                            <li><a href="{{ url('principle-message') }}">Principle Message</a></li>



                            <li><a href="{{ url('oath') }}">Oath</a></li>

                            <li><a href="{{ url('accomplishment') }}">Accomplishment</a></li>


                        </ul>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="#">Media</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('gallery') }}">Gallery</a></li>
                            <li><a href="{{ url('video') }}">Video</a></li>
                            <li><a href="{{ url('testimonial') }}">Testimonial</a></li>
                            <li><a href="{{ url('faq') }}">Faq</a></li>
                            <li><a href="{{ url('blogs') }}">Blogs</a></li>


                        </ul>
                    </li>

                    <li><a href="{{ url('service') }}">Service</a></li>

                    <li>
                        <a href="{{ url('events') }}">Events</a>

                    </li>
                    <li>
                        <a href="{{ url('academics') }}">Academics</a>

                    </li>

                    <li>
                        <a href="{{ url('facility') }}">Facilities</a>

                    </li>
                    <li>
                        <a href="{{ url('programs') }}">Programs</a>

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
                    <p class="mb-0">We are constantly expanding the range of services offered, taking care of children
                        of all ages.</p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div>
                    <p class="footer-text">Monday to Friday: <span class="time">7:00 am - 5:30 pm</span></p>
                    <p class="footer-text">Saturday: <span class="time">Office timing may vary</span></p>
                    <p class="footer-info"><i class="fal fa-envelope"></i>Email: <a
                            href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></p>
                    <p class="footer-info"><i class="fas fa-mobile-alt"></i>Phone: <a href="tel:+📞 +977-25-525300">📞
                            +977-25-525300</a></p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Latest News</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="{{ url('blog-detail') }}"><img
                                    src="{{ url('assets/frontend/img/blog/recent-post-1-1.jpg') }}"
                                    alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="{{ url('blog') }}"><i class="far fa-calendar-alt"></i>December 3, 2022</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="{{ url('blog-detail') }}">A very warm welcome
                                    to our new Treasurer</a></h4>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="{{ url('blog-detail') }}"><img
                                    src="{{ url('assets/frontend/img/blog/recent-post-1-2.jpg') }}"
                                    alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="{{ url('blog') }}"><i class="far fa-calendar-alt"></i>February 15, 2022</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="{{ url('blog-detail') }}">German kinder and
                                    garten mean child</a></h4>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="{{ url('blog-detail') }}"><img
                                    src="{{ url('assets/frontend/img/blog/recent-post-1-3.jpg') }}"
                                    alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="{{ url('blog') }}"><i class="far fa-calendar-alt"></i>Augest 20, 2022</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="{{ url('blog-detail') }}">English uses term to
                                    refer to the earliest</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-search-box d-none d-lg-block  ">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="What are you looking for">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>

    <header class="vs-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links style-white">
                            <ul>
                                <li><a href="#"><i class="far fa-user-circle"></i>Login & Register</a>
                                </li>
                                <li><a href="#" class="searchBoxTggler"><i class="far fa-search"></i>Search
                                        Keyword</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-auto text-center">
                        <div class="header-links style2 style-white">
                            <ul>
                                <li><i class="fas fa-envelope"></i>Email: <a href="mailto:kkisdharan@gmail.com">kkisdharan@gmail.com</a></li>
                                <li><i class="fas fa-mobile-alt"></i>Phone: <a href="tel:+📞 +977-25-525300">📞
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
                                            <li><a href="{{ url('about-us') }}">About us</a></li>
                                            <li><a href="{{ url('team') }}">Team</a></li>
                                            <li><a href="{{ url('goal') }}">Goal</a></li>
                                            <li><a href="{{ url('mission') }}">Mission</a></li>
                                            <li><a href="{{ url('director-message') }}">Director Message</a></li>
                                            <li><a href="{{ url('principle-message') }}">Principle Message</a></li>


                                            <li><a href="{{ url('oath') }}">Oath</a></li>

                                            <li><a href="{{ url('accomplishment') }}">Accomplishment</a></li>


                                        </ul>
                                    </li>

                                    <li class="menu-item-has-children">
                                        <a href="#">Media</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('gallery') }}">Gallery</a></li>
                                            <li><a href="{{ url('video') }}">Video</a></li>
                                            <li><a href="{{ url('testimonial') }}">Testimonial</a></li>
                                            <li><a href="{{ url('faq') }}">Faq</a></li>
                                            <li><a href="{{ url('blogs') }}">Blogs</a></li>


                                        </ul>
                                    </li>

                                    <li><a href="{{ url('service') }}">Service</a></li>
                                    <li>
                                        <a href="{{ url('events') }}">Events</a>

                                    </li>
                                    <li>
                                        <a href="{{ url('academics') }}">Academics</a>

                                    </li>
                                    <li>
                                        <a href="{{ url('facility') }}">Facilities</a>

                                    </li>
                                    <li>
                                        <a href="{{ url('program') }}">Programs</a>

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
