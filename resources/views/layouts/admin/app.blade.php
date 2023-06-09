<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('./asset/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('./asset/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('./asset/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('./asset/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('./asset/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="{{asset('./asset/text/css" href="js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('./asset/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{URL('./asset/images/logo-surakarta.png')}}" />
</head>
<body>
    <div class="container-scroller">
        @extends('layouts.admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.admin.sidebar')
            @yield('main')
        </div>
        @extends('layouts.footer')
    </div>

    <!-- plugins:js -->
    <script src="{{asset('./asset/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('./asset/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('./asset/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('./asset/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('./asset/js/dataTables.select.min.js')}}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('./asset/js/off-canvas.js')}}"></script>
    <script src="{{asset('./asset/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('./asset/js/template.js')}}"></script>
    <script src="{{asset('./asset/js/settings.js')}}"></script>
    <script src="{{asset('./asset/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('./asset/js/dashboard.js')}}"></script>
    <script src="{{asset('./asset/js/Chart.roundedBarCharts.js')}}"></script>
    <!-- End custom js for this page-->
</body>

</html>