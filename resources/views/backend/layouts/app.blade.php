@php

    $companyProfile = DB::table('tbl_general')->where('id',1)->first();

    @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $companyProfile->school_name }} | Dashboard</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{url('assets/plugins/jqvmap/jqvmap.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url('assets/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->


    <link rel="stylesheet" href="{{url('assets/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="icon" href="{{ asset('public/uploads/'.$companyProfile->company_logo) }}" type="image/x-icon">


    <link rel="stylesheet" href="{{url('assets/style.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- mutilple selected data  -->

    <link rel="stylesheet" href="{{url('assets/plugins/select2/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('assets/dist/css/adminlte.min.css')}}">



    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>



<style>
  
.toast-success {
    position: fixed;
    top: 25px;
    right: -400px;
    background: #12b91b; /* GREEN */
    color: #ffffff; /* text white */
    padding: 14px 22px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.18);
    font-size: 15px;
    font-weight: 700; /* BOLD TEXT */
    z-index: 9999;
    min-width: 260px;
    transition: all 0.5s ease;
    opacity: 0;
}

.toast-success.show {
    right: 25px;
    opacity: 1;
}

/* TICK ICON BLUE */
.toast-icon {
    background: #1e88e5; /* BLUE COLOR */
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    font-size: 20px;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #fff;
}

</style>


</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        <!-- SUCCESS TOAST -->
        <div id="toastSuccess" class="toast-success">
            <div class="toast-icon">✔</div>
            <div class="toast-message">{{ session('success') }}</div>
        </div>
        
        <!-- ERROR TOAST -->
        <div id="toastError" class="toast-error">
            <div class="toast-icon">✖</div>
            <div class="toast-message">{{ session('error') }}</div>
        </div>
        
        <!-- SUCCESS SOUND -->
        <audio id="successSound">
            <source src="{{ asset('public/success.mp3') }}" type="audio/mpeg">
        </audio>
        
        <!-- ERROR SOUND -->
        <audio id="errorSound">
            <source src="{{ asset('public/error.mp3') }}" type="audio/mpeg">
        </audio>


        @include('backend.layouts.header')

        @yield('content')

        @include('backend.layouts.footer')




        <!-- jQuery UI 1.11.4 -->
        <script src="{{url('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{url('assets/plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{url('assets/plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{url('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{url('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{url('assets/plugins/moment/moment.min.js')}}"></script>
        <script src="{{url('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- Summernote -->
        <script src="{{url('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{url('assets/dist/js/adminlte.js?v=3.2.0')}}"></script>

        <script src="{{url('assets/dist/js/pages/dashboard.js')}}"></script>



        <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
            });

            $('form').on('submit', function() {
                $('.summernote').each(function() {
                    $(this).val($(this).summernote('code'));
                });
            });
        });
        </script>




    
        <!-- multiple selected data -->

        <!-- Select2 -->
        <script src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>
        <!-- Bootstrap4 Duallistbox -->

        <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

        })
        </script>

        <script>
        $(document).ready(function() {
            $('#tablesearchfilter').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true,
                "lengthChange": true, 
                "language": {
                    "search": " Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No matching data found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ data",
                    "infoEmpty": "No data available",
                    "infoFiltered": "(filtered from _MAX_ total data)"
                }
            });
        });
        </script>



<script>
document.addEventListener("DOMContentLoaded", function () {

    @if(session('success'))
        playSuccessSound();
        showToast("toastSuccess");
    @endif

    @if(session('error'))
        playErrorSound();
        showToast("toastError");
    @endif

});

// COMMON TOAST FUNCTION
function showToast(id) {
    const toast = document.getElementById(id);
    if (!toast) return;

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

// SUCCESS SOUND
function playSuccessSound() {
    const audio = document.getElementById("successSound");
    if (audio) {
        audio.volume = 0.7;
        audio.play();
    }
}

// ERROR SOUND
function playErrorSound() {
    const audio = document.getElementById("errorSound");
    if (audio) {
        audio.volume = 0.7;
        audio.play();
    }
}
</script>

</body>

</html>