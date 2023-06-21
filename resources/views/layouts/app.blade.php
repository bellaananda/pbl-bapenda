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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('additional')
</head>
<body>
    <div class="container-scroller">
        @extends('../layouts.navbar')
        <div class="container-fluid page-body-wrapper">
            @yield('main')
        </div>
        @extends('../layouts.footer')
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

    @if (Session::has('success_message'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success_message') }}',
                    timer: 2000, // Display duration in milliseconds
                    showConfirmButton: false,
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
            });
        </script>
    @endif

    @if (Session::has('error_message'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error_message') }}',
                    timer: 2000, // Display duration in milliseconds
                    showConfirmButton: false,
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
            });
        </script>
    @endif

    <style>
        .swal-icon-custom {
            position: relative;
            top: 20px;
        }
    </style>

    @if(request()->query('refresh'))
        <script>
            window.onload = function() {
                window.location.reload();
            }
        </script>
    @endif

</body>

</html>