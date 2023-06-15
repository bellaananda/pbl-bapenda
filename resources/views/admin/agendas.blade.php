@extends('../layouts.admin.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
            <h3 class="font-weight-bold">DATA AGENDA</h3>
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
                <div class="col-md-6" style="text-align: right">
                    <div class="template-demo">
                        <button type="button" class="btn btn-info btn-icon-text" data-toggle="modal" data-target="#copyModal">
                            <i class="mdi mdi-content-copy btn-icon-prepend"></i>
                            Salin
                        </button>
                        <button type="button" class="btn btn-success btn-icon-text" data-toggle="modal" data-target="#excelModal">
                            <i class="mdi mdi-file-excel btn-icon-prepend"></i>
                            Unduh Excel
                        </button>
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
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ ($loop->index + 1) + 15*($currentPage-1) }}</td>
                                                <td>{{ $item['title'] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item['date'])) }}</td>
                                                @if ($item['end_time'] != null)
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) . ' - ' . date('H:i', strtotime($item['end_time'])) }}</td>
                                                @else
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) }}</td>                                            
                                                @endif
                                                <td>{{ $item['disposition'] }}</td>
                                                <td>{{ $item['location'] }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal{{$loop->index}}">
                                                        Detail
                                                    </a>
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
                                                                        @elseif (substr(strrchr($item['attachment'], '.'), 1) == 'jpg' || substr(strrchr($item['attachment'], '.'), 1) == 'jpge' || substr(strrchr($item['attachment'], '.'), 1) == 'png')
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

            <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="copyModalLabel">Salin Agenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="copydate" class="font-weight-bold">Pilih Tanggal</label>
                            <input type="date" class="form-control" id="copydate" name="copydate" value="{{date('Y-m-d')}}"/>
                            <button type="submit" class="btn btn-info btn-icon-text btn-sm my-3 float-right" onclick="copyToClipboard()">
                                <i class="ti-files btn-icon-prepend"></i>                                                    
                                Salin
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary text-white" data-dismiss="modal">Tutup</button>                    
                    </div>
                </div>
                </div>
            </div>
            <div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="excelModalLabel">Ekspor Agenda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form action="/download-agenda-excel" method="get">
                                <label for="exceldate" class="font-weight-bold">Pilih Bulan</label>
                                <input type="month" class="form-control" id="exceldate" name="exceldate" value="{{date('Y-m')}}">
                                <button type="submit" class="btn btn-info btn-icon-text btn-sm my-3 float-right">
                                    <i class="mdi mdi-file-excel btn-icon-prepend"></i>                                                    
                                    Ekspor
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary text-white" data-dismiss="modal">Tutup</button>                    
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

    <script type="text/javascript">
        function copyToClipboard() {
            // Get the selected date from the datepicker
            var selectedDate = $('#copydate').val();

            // Make an AJAX request to retrieve the data from the controller
            const token= `{{ Session::get('access_token') }}`;
            axios.post('https://api.klikagenda.com/api/generate-agenda-text', {
                date: selectedDate,
            }, {
                headers: { Authorization: `Bearer ${token}` }
            })
            .then(function(response) {
                console.log(response)
                // Copy the data to the clipboard
                var textToCopy = response.data;
                navigator.clipboard.writeText(textToCopy)
    
                // Show a success message or perform any other actions
                Swal.fire({
                    title: 'Informasi',
                    text: 'Data agenda berhasil disalin!',
                    icon: 'success',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                })
            })
            .catch(function(error) {
                // Handle any errors
                console.log(error);
            });
        }
    
        // Initialize the datepicker
        $( "#copydate" ).datepicker();
    </script>
    <style>
        .swal-icon-custom {
            margin-top: 100px;
        }
    </style>
@endsection