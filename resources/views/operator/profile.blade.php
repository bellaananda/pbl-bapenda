@extends('../layouts.operator.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin title">
                    <div class="row">
                        <div class="col-12 align-items-center">
                            <h3 class="font-weight-bold">PROFIL</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-description float-right"></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Nama</th>
                                            <th style="width: 50%;">NIP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$data['name']}}</td>
                                            <td>{{$data['nip']}}</td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Bidang</th>
                                            <th style="width: 50%;">Posisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$data['department']}}</td>
                                            <td>{{$data['position']}}</td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">No. Telepon</th>
                                            <th style="width: 50%;">Alamat Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$data['phone_number']}}</td>
                                            <td>{{$data['email']}}</td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Status</th>
                                            <th style="width: 50%;">Password</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: top; text-align: left;">
                                                @if ($data['status'] == 1)
                                                    <span class="btn btn-success btn-rounded" disabled>{{$data['status_name']}}</span>
                                                @else
                                                    <span class="btn btn-danger btn-rounded" disabled>{{$data['status_name']}}</span>
                                                @endif
                                            </td>
                                            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;">
                                                <p>
                                                    Anda dapat mengubah password dengan menekan tombol <b>Ubah Password</b> di bawah ini. Pastikan anda mencatat/mengingat password baru anda. Jika selanjutnya anda lupa password maka anda harus menghubungi admin untuk melakukan reset password.
                                                </p>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#passwordModal">Ubah Password</button>
                                                <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true"> 
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title display-5" id="passwordModalLabel">Ubah Password</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="/password" method="POST" enctype="multipart/form-data" id="updateForm">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="password" class="font-weight-bold">Password Baru</label>
                                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Baru" value="{{ old('password') }}" required>
                                                                        @error('password')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password_confirm" class="font-weight-bold">Konfirmasi Password Baru</label>
                                                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Masukkan Konfirmasi Password Baru" value="{{ old('password_confirm') }}" required>
                                                                        @error('password_confirm')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                                                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); validateForm()">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk mengubah password? Setelah ini, anda akan logout dari akun dan login dengan password baru.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ubah Password',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete route
                    document.getElementById('updateForm').submit();
                }
            });
        }

        function validateForm() {
            var password = document.getElementById('password').value;
            var passwordConfirm = document.getElementById('password_confirm').value;

            // Reset error messages

            if (password !== passwordConfirm) {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Konfirmasi password tidak sesuai.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (password.length < 8 || !/\d/.test(password)) {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Password harus terdiri dari minimal 8 karakter dan mengandung angka.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            confirmUpdate();
        }
    </script>
@endsection