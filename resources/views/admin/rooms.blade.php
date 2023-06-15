@extends('../layouts.admin.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="font-weight-bold">KELOLA DATA RUANGAN</h3>
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Ruangan</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ruang</th>
                                            <th></th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{$item['name']}}</td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$loop->index}}">
                                                        <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                                    </a>
                                                    <form action="/ruangan/{{$item['id']}}" method="POST" id="deleteForm{{ $item['id'] }}" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete('{{ $item['id'] }}')">
                                                            <i class="mdi mdi-delete btn-icon-prepend"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editModal{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true"> 
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title display-5" id="editModalLabel">Edit Ruangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="/ruangan/{{$item['id']}}" method="POST" enctype="multipart/form-data" id="updateForm{{ $item['id'] }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="name" class="font-weight-bold">Nama</label>
                                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Ruangan" value="{{ old('name', $item['name']) }}" required>
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
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
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4 class="card-title">Tambah Ruangan</h4>
                                <form action="/ruangan" method="post" id="createForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama Ruangan</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Ruangan" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); confirmCreate()">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmDelete(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete route
                    document.getElementById('deleteForm' + itemId).submit();
                }
            });
        }
        function confirmUpdate(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menyimpan perubahan data?',
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
        function confirmCreate() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menambahkan data?',
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
                    document.getElementById('createForm').submit();
                }
            });
        }
    </script>
    <style>
        .swal-icon-custom {
            margin-top: 100px;
        }
    </style>
@endsection