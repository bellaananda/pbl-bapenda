@extends('../layouts.operator.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
            <h3 class="font-weight-bold">DATA PENGAJUAN AGENDA</h3>
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="card-body">
                        <form action="/agenda" method="get">
                            <div class="input-group">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari Agenda" aria-label="Cari Agenda">
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
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Agenda</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Disposisi</th>
                                            <th>Tempat</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ ($loop->index + 1) + 15*($currentPage-1) }}</td>
                                                <td class="max-width-column">{{ $item['title'] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item['date'])) }}</td>
                                                @if ($item['end_time'] != null)
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) . ' - ' . date('H:i', strtotime($item['end_time'])) }}</td>
                                                @else
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) }}</td>                                            
                                                @endif
                                                <td class="max-width-column">{{ $item['disposition'] }}</td>
                                                <td class="max-width-column">{{ $item['location'] }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal{{$loop->index}}">
                                                        <i class="mdi mdi-magnify btn-icon-prepend"></i>
                                                    </a>
                                                    <form action="/approve-pengajuan/{{$item['id']}}" method="POST" id="approveForm{{ $item['id'] }}" style="display: inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="event.preventDefault(); confirmApprove('{{ $item['id'] }}')">
                                                            <i class="mdi mdi-check btn-icon-prepend"></i>
                                                        </button>
                                                    </form>
                                                    <form action="/deny-pengajuan/{{$item['id']}}" method="POST" id="denyForm{{ $item['id'] }}" style="display: inline">
                                                        @csrf
                                                        <input type="hidden" id="notes" name="notes">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDeny('{{ $item['id'] }}')">
                                                            <i class="mdi mdi-close btn-icon-prepend"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="detailModal{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true"> 
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title display-5" id="detailModalLabel">Detail Agenda</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="title" class="font-weight-bold">Judul Agenda</label>
                                                                        <input type="text" class="form-control" id="title" value="{{$item['title']}}" disabled/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="date" class="font-weight-bold">Tanggal</label>
                                                                        <input type="date" class="form-control" id="date" value="{{$item['date']}}" disabled/>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="start_time" class="font-weight-bold">Waktu Mulai</label>
                                                                                <input type="time" class="form-control" id="start_time" value="{{$item['start_time']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="end_time" class="font-weight-bold">Waktu Selesai</label>
                                                                                <input type="time" class="form-control" id="end_time" value="{{$item['end_time']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="location" class="font-weight-bold">Kategori</label>
                                                                        <input type="text" class="form-control" id="location" value="{{$item['category']}}" disabled/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="location" class="font-weight-bold">Bidang</label>
                                                                        <input type="text" class="form-control" id="location" value="{{$item['department']}}" disabled/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="location" class="font-weight-bold">Penanggung Jawab</label>
                                                                        <input type="text" class="form-control" id="location" value="{{$item['person_in_charge']}}" disabled/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="user" class="font-weight-bold">Pembuat Ajuan</label>
                                                                        <input type="text" class="form-control" id="user" value="{{$item['user']}}" disabled/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="location" class="font-weight-bold">Tempat</label>
                                                                        <input type="text" class="form-control" id="location" value="{{$item['location']}}" disabled/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="disposition" class="font-weight-bold">Peserta</label>
                                                                        <textarea class="form-control" id="disposition" rows="4" disabled>{{$item['disposition']}}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="contents" class="font-weight-bold">Isi Agenda</label>
                                                                        <textarea class="form-control" id="disposition" rows="4" disabled>{{$item['contents']}}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="attachment" class="font-weight-bold">Lampiran</label><br>
                                                                        @if (substr(strrchr($item['attachment'], '.'), 1) == 'PDF')
                                                                            <embed id="attachment" src="{{ $fileUrl.$item['attachment'] }}" width="600px" height="150px" />
                                                                        @elseif (substr(strrchr($item['attachment'], '.'), 1) == 'jpg' || substr(strrchr($item['attachment'], '.'), 1) == 'jpeg' || substr(strrchr($item['attachment'], '.'), 1) == 'png')
                                                                            <img src="{{ $fileUrl.$item['attachment'] }}" alt="File Preview">
                                                                        @endif
                                                                        <a href="{{ $fileUrl.$item['attachment'] }}" download="{{ $item['attachment'] }}">Unduh Lampiran</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-primary text-white" data-dismiss="modal">Tutup</button>
                                                        </div>
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
                        <li><a href="/agenda?page={{$i+1}}" class="@if($i+1==$currentPage) active @endif">{{$i+1}}</a></li>
                    @endfor
                </ul>
            </div>
        
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{asset('./asset/js/file-upload.js')}}"></script>

    <script type="text/javascript">
        function confirmApprove(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menerima pengajuan agenda? Tindakan ini tidak dapat dibatalkan, pastikan anda sudah mengecek data.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Terima',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approveForm' + itemId).submit();
                }
            });
        }

        function confirmDeny(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menolak pengajuan agenda? Tindakan ini tidak dapat dibatalkan, pastikan anda sudah mengecek data.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    icon: 'swal-icon-custom' // Add your custom CSS class here
                },
                input: 'textarea',
                inputValue: '',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Masukkan catatan penolakan', // Set the placeholder text
                    name: 'notes', // Set the name attribute
                    id: 'notes',
                    rows: 4
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan wajib diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('notes').value = result.value;
                    document.getElementById('denyForm' + itemId).submit();
                }
            });
        }
    
        // Initialize the datepicker
        $( "#copydate" ).datepicker();
    </script>

    <style>
        .swal-icon-custom {
            margin-top: 100px;
        }
        .max-width-column {
            max-width: 200px; /* Ubah nilai sesuai kebutuhan */
            white-space: nowrap; /* Untuk mencegah pemotongan teks */
            overflow: hidden; /* Untuk menyembunyikan konten yang terpotong */
            text-overflow: ellipsis; /* Untuk menampilkan tanda elipsis (...) jika terpotong */
        }
    </style>
@endsection