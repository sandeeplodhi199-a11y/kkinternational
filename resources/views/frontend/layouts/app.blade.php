<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>KK International School</title>
    <meta name="author" content="Vecuro">
    <meta name="description" content="Kiddino - Children School & Kindergarten HTML Template">
    <meta name="keywords" content="Kiddino - Children School & Kindergarten HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('assets/frontend/img/202606011816kk_logo.jpeg') }}" type="image/x-icon">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../../css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500&display=swap" rel="stylesheet">


    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/bootstrap.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ url('assets/frontend/css/app.min.css') }}"> -->
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/fontawesome.min.css') }}">
    <!-- Layerslider -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/layerslider.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/magnific-popup.min.css') }}">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/slick.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/style.css') }}">

    <style>
    .logo img {
        height: 70px;
        /* fixed height */
        width: auto;
        /* aspect ratio safe */
        object-fit: contain;
        display: block;
    }
    </style>

</head>



<body>

    <script>
        (function () {
            document.oncontextmenu = null;
            document.onkeydown = null;
            window.oncontextmenu = null;
            window.onkeydown = null;

            document.addEventListener('contextmenu', function (event) {
                event.stopImmediatePropagation();
            }, true);

            document.addEventListener('keydown', function (event) {
                if ((event.ctrlKey || event.metaKey) && String(event.key).toLowerCase() === 'u') {
                    event.stopImmediatePropagation();
                }
            }, true);
        })();
    </script>




    @include('frontend.layouts.header')
    @yield('content')
    @include('frontend.layouts.footer')



    <!-- Jquery -->
    <script src="{{ url('assets/frontend/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ url('assets/frontend/js/slick.min.js') }}"></script>
    <!-- <script src="{{ url('assets/frontend/js/app.min.js') }}"></script> -->

    <script src="{{ url('assets/frontend/js/layerslider.utils.js') }}"></script>
    <script src="{{ url('assets/frontend/js/layerslider.transitions.js') }}"></script>
    <script src="{{ url('assets/frontend/js/layerslider.kreaturamedia.jquery.js') }}"></script>
    <!-- jquery ui -->
    <script src="{{ url('assets/frontend/js/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('assets/frontend/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ url('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ url('assets/frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/frontend/js/isotope.pkgd.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ url('assets/frontend/js/main.js') }}"></script>


</body>

</html>
