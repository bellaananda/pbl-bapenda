@extends('../layouts.admin.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style class="pagination justify-content-center">
        ul.pagination {
            display: inline-block;
            padding: 0;
            margin: 0;
        }
        
        ul.pagination li {display: inline;}
        
        ul.pagination li a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        
        ul.pagination li a.active {
            background-color: #3f2ab5;
            color: white;
            border: 1px solid #3f2ab5;
        }
        
        ul.pagination li a:hover:not(.active) {background-color: #ddd;}
    </style>
@endsection

@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="font-weight-bold">DATA PEGAWAI</h3>
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="card-body">
                        <form action="/pegawai" method="get">
                            <div class="input-group">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari Pegawai" aria-label="Cari Pegawai" value="{{ request()->input('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">
                                        <i class="ti-search text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="card-title">Data Pegawai</h4> --}}
                            <div class="card-tools float-right">
                                <div class="input-group input-group-sm">
                                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#employeeModalCreate">
                                        Tambah
                                    </button>
                                </div> 
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>No. Telp</th>
                                            <!-- <th>Role</th> -->
                                            <th>Status</th>
                                            <th>Posisi</th>
                                            <th></th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ ($loop->index + 1) + 15*($currentPage-1) }}</td>
                                                <td>{{$item['nip']}}</td>
                                                <td class="max-width-column">{{$item['name']}}</td>
                                                <td>{{$item['phone_number']}}</td>
                                                <td>
                                                    @if ($item['status'] == 1)
                                                        <span class="badge badge-success">{{$item['status_name']}}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{$item['status_name']}}</span>
                                                    @endif
                                                </td>
                                                <td class="max-width-column">{{$item['position']}}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal{{$loop->index}}">
                                                        <i class="mdi mdi-magnify btn-icon-prepend"></i>
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$loop->index}}">
                                                        <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                                    </a>
                                                    <form action="/password-reset/{{$item['id']}}" method="POST" id="resetPassword{{ $item['id'] }}" style="display: inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning text-white" onclick="event.preventDefault(); confirmReset('{{ $item['id'] }}')">
                                                            <i class="mdi mdi-sync btn-icon-prepend"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="detailModal{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true"> 
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title display-5" id="detailModalLabel">Detail Pegawai</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="nip" class="font-weight-bold">NIP</label>
                                                                        <input type="text" class="form-control" id="nip" name="nip" value="{{ $item['nip'] }}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="name" class="font-weight-bold">Nama</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $item['name'] }}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email" class="font-weight-bold">Email</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $item['email'] }}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="phone_number" class="font-weight-bold">No. Telepon</label>
                                                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan Nomor Telepon Pegawai" value="{{ $item['phone_number'] }}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="address" class="font-weight-bold">Alamat</label>
                                                                        <textarea class="form-control" id="address" name="address" rows="4" disabled>{{ $item['address'] }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="position_id" class="font-weight-bold">Posisi</label>
                                                                        <select class="form-control" id="position_id" name="position_id" disabled>
                                                                            <option disabled value selected>Pilih Posisi Pegawai</option>
                                                                            @foreach ($positions as $position)
                                                                                <option {{ (old("position_id", $position['id'])==$item['position_id'])?'selected':'' }} value="{{$position['id']}}">{{$position['name']}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="department_id" class="font-weight-bold">Bidang Pegawai</label>
                                                                        <select class="form-control" id="department_id" name="department_id" disabled>
                                                                            <option disabled value selected>Pilih Bidang Pegawai</option>
                                                                            @foreach ($departments as $department)
                                                                                <option {{ (old("department_id", $department['id'])==$item['department_id'])?'selected':'' }} value="{{$department['id']}}">{{$department['name']}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="role" class="font-weight-bold">Hak Akses</label>
                                                                        <select class="form-control" id="role" name="role" disabled>
                                                                            <option disabled value selected>Pilih Hak Akses</option>
                                                                            <option {{ (old("role", $item['role'])=='user')?'selected':'' }} value="user">Pengguna Biasa</option>
                                                                            <option {{ (old("role", $item['role'])=='operator')?'selected':'' }} value="operator">Operator</option>
                                                                            <option {{ (old("role", $item['role'])=='admin')?'selected':'' }} value="admin">Admin</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status" class="font-weight-bold">Status</label>
                                                                        <select class="form-control" id="status" name="status" disabled>
                                                                            <option disabled value selected>Pilih Status Pegawai</option>
                                                                            <option {{ (old("status", $item['status'])==1)?'selected':'' }} value="1">Aktif</option>
                                                                            <option {{ (old("status", $item['status'])==0)?'selected':'' }} value="0">Nonaktif</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="editModal{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true"> 
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title display-5" id="editModalLabel">Edit Pegawai</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="/pegawai/{{$item['id']}}" method="POST" enctype="multipart/form-data" id="updateForm{{ $item['id'] }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="nip" class="font-weight-bold">NIP</label>
                                                                            <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP Pegawai" value="{{ old('nip', $item['nip']) }}" required>
                                                                            @error('nip')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name" class="font-weight-bold">Nama</label>
                                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Pegawai" value="{{ old('name', $item['name']) }}" required>
                                                                            @error('name')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="email" class="font-weight-bold">Email</label>
                                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Pegawai" value="{{ old('email', $item['email']) }}" required>
                                                                            @error('email')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="phone_number" class="font-weight-bold">No. Telepon</label>
                                                                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan Nomor Telepon Pegawai" value="{{ old('phone_number', $item['phone_number']) }}" required>
                                                                            @error('phone_number')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="address" class="font-weight-bold">Alamat</label>
                                                                            <textarea class="form-control" id="address" name="address" rows="4" placeholder="Masukkan Alamat Pegawai"required>{{ old('address', $item['address']) }}</textarea>
                                                                            @error('address')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="position_id" class="font-weight-bold">Posisi</label>
                                                                            <select class="form-control" id="position_id" name="position_id" required>
                                                                                <option disabled value selected>Pilih Posisi Pegawai</option>
                                                                                @foreach ($positions as $position)
                                                                                    <option {{ (old("position_id", $position['id'])==$item['position_id'])?'selected':'' }} value="{{$position['id']}}">{{$position['name']}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('position_id')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="department_id" class="font-weight-bold">Bidang Pegawai</label>
                                                                            <select class="form-control" id="department_id" name="department_id" required>
                                                                                <option disabled value selected>Pilih Bidang Pegawai</option>
                                                                                @foreach ($departments as $department)
                                                                                    <option {{ (old("department_id", $department['id'])==$item['department_id'])?'selected':'' }} value="{{$department['id']}}">{{$department['name']}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('department_id')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="role" class="font-weight-bold">Hak Akses</label>
                                                                            <select class="form-control" id="role" name="role" required>
                                                                                <option disabled value selected>Pilih Hak Akses</option>
                                                                                <option {{ (old("role", $item['role'])=='user')?'selected':'' }} value="user">Pengguna Biasa</option>
                                                                                <option {{ (old("role", $item['role'])=='operator')?'selected':'' }} value="operator">Operator</option>
                                                                                <option {{ (old("role", $item['role'])=='admin')?'selected':'' }} value="admin">Admin</option>
                                                                            </select>
                                                                            @error('position_id')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="status" class="font-weight-bold">Status</label>
                                                                            <select class="form-control" id="status" name="status" required>
                                                                                <option disabled value selected>Pilih Status Pegawai</option>
                                                                                <option {{ (old("status", $item['status'])==1)?'selected':'' }} value="1">Aktif</option>
                                                                                <option {{ (old("status", $item['status'])==0)?'selected':'' }} value="0">Nonaktif</option>
                                                                            </select>
                                                                            @error('position_id')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); confirmUpdate('{{ $item['id'] }}')">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination justify-content-center">
                <ul class="pagination">
                    @for ($i = 0; $i <= $totalPagination; $i++)
                        <li><a href="/pegawai?page={{$i+1}}" class="@if($i+1==$currentPage) active @endif">{{$i+1}}</a></li>
                    @endfor
                </ul>
            </div>

            <div class="modal fade" id="employeeModalCreate" tabindex="-1" role="dialog" aria-labelledby="employeeModalCreateLabel" aria-hidden="true"> 
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title display-5" id="employeeModalCreateLabel">Tambah Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/pegawai" method="POST" enctype="multipart/form-data" id="createForm">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nip" class="font-weight-bold">NIP</label>
                                            <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP Pegawai" value="{{ old('nip') }}" required>
                                            @error('nip')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Nama Pegawai</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Pegawai" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bold">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Pegawai" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number" class="font-weight-bold">No. Telepon</label>
                                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan Nomor Telepon Pegawai" value="{{ old('phone_number') }}" required>
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address" class="font-weight-bold">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" rows="4" placeholder="Masukkan Alamat Pegawai"required>{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="position_id" class="font-weight-bold">Posisi Pegawai</label>
                                            <select class="form-control" id="position_id" name="position_id" required>
                                                <option disabled value selected>Pilih Posisi Pegawai</option>
                                                @foreach ($positions as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('position_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="department_id" class="font-weight-bold">Bidang Pegawai</label>
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <option disabled value selected>Pilih Bidang Pegawai</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); confirmCreate()">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmCreate() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menambahkan data pegawai? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete route
                    document.getElementById('createForm').submit();
                }
            });
        }
        function confirmUpdate(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menyimpan perubahan data pegawai?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete route
                    document.getElementById('updateForm' + itemId).submit();
                }
            });
        }
        function confirmReset(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk mereset password pengguna ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Reset',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resetPassword' + itemId).submit();
                }
            });
        }
    </script>
    <style>
        .swal-icon-custom {
            position: relative;
            top: 20px;
        }
        .max-width-column {
            max-width: 200px; /* Ubah nilai sesuai kebutuhan */
            white-space: nowrap; /* Untuk mencegah pemotongan teks */
            overflow: hidden; /* Untuk menyembunyikan konten yang terpotong */
            text-overflow: ellipsis; /* Untuk menampilkan tanda elipsis (...) jika terpotong */
        }
    </style>
@endsection