<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BAPENDA Surakarta - Login</title>
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
    @yield('additional')
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="asset/images/logo-bapenda.svg" alt="logo">
                            </div>
                            <h3>Login</h3>
                            <h6 class="font-weight-light">Masukkan email dan password untuk dapat login</h6>
                            <form action="/login" method="post" class="pt-3" @submit.prevent="login">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-block my-4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
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
</body>

</html>