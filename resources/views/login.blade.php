@extends('../layouts.app')

@section('title', 'BAPENDA Surakarta - Login')

@section('main')
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
@endsection
