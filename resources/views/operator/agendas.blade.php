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
            <h3 class="font-weight-bold">DATA AGENDA</h3>
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="card-body">
                        <form action="/agenda" method="get">
                            <div class="input-group">
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari Agenda" aria-label="Cari Agenda" value="{{ request()->input('search') }}">
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
                            <div class="card-tools float-right mb-4">
                                <div class="input-group input-group-sm">
                                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                        Tambah
                                    </button>
                                </div> 
                            </div>
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
                                                                            <embed id="attachment" src="{{ $fileUrl.$item['attachment'] }}" width="600px" height="150px" alt="Lampiran" />
                                                                        @elseif (substr(strrchr($item['attachment'], '.'), 1) == 'jpg' || substr(strrchr($item['attachment'], '.'), 1) == 'jpeg' || substr(strrchr($item['attachment'], '.'), 1) == 'png')
                                                                            <img src="{{ $fileUrl.$item['attachment'] }}" alt="Lampiran" style="max-width: 600px; max-height: 150px;">
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
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true"> 
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title display-5" id="createModalLabel">Tambah Agenda</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/agenda" method="post" id="createForm" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="font-weight-bold">Judul Agenda</label>
                                            <span class="required-field">*</span>
                                            <input type="text" class="form-control" id="create_title" name="title" value="{{old('title')}}" placeholder="Masukkan Judul Agenda" required/>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="date" class="font-weight-bold">Tanggal</label>
                                            <span class="required-field">*</span>
                                            <input type="date" class="form-control" id="create_date" name="date" value="{{old('date') ?? date('Y-m-d')}}" required/>
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="room_id" class="font-weight-bold">Tempat</label>
                                            <span class="required-field">*</span>
                                            <select class="form-control" id="create_room_id" name="room_id" required>
                                                <option disabled value selected>Pilih Tempat</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{$room['id']}}" {{ old('room_id') == $room['id'] ? 'selected' : '' }}>{{$room['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('room_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group" id="textareaLocation" style="display: none;">
                                            <label for="location" id="location_label" class="font-weight-bold"></label>
                                            <span class="required-field">*</span>
                                            <textarea class="form-control" id="create_location" name="location" rows="4" placeholder="Masukkan Detail Tempat" required>{{ old('location') }}</textarea>
                                            @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_time" class="font-weight-bold">Waktu Mulai</label>
                                                    <span class="required-field">*</span>
                                                    <input type="time" class="form-control" id="create_start_time" name="start_time" value="{{old('start_time')}}" required/>
                                                    @error('start_time')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_time" class="font-weight-bold">Waktu Selesai</label>
                                                    <span class="required-field">*</span>
                                                    <input type="time" class="form-control" id="create_end_time" name="end_time" value="{{old('end_time')}}"/>
                                                    @error('end_time')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="disposition_description" class="font-weight-bold">Peserta</label>
                                            <span class="required-field">*</span>
                                            <textarea class="form-control" id="create_disposition_description" name="disposition_description" rows="4" required placeholder="Masukkan Peserta Agenda">{{old('disposition_description')}}</textarea>
                                            @error('disposition_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id" class="font-weight-bold">Kategori</label>
                                            <span class="required-field">*</span>
                                            <select class="form-control" id="create_category_id" name="category_id" required>
                                                <option disabled value selected>Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category['id']}}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>{{$category['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="department_id" class="font-weight-bold">Bidang</label>
                                            <span class="required-field">*</span>
                                            <select class="form-control" id="create_department_id" name="department_id" required>
                                                <option disabled value selected>Pilih Bidang</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{$department['id']}}" {{ old('department_id') == $department['id'] ? 'selected' : '' }}>{{$department['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="person_in_charge" class="font-weight-bold">Penanggung Jawab</label>
                                            <span class="required-field">*</span>
                                            <select class="form-control" id="create_person_in_charge" name="person_in_charge" required>
                                                <option value="" selected disabled>Pilih Penanggung Jawab</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee['id']}}" {{ old('person_in_charge') == $employee['id'] ? 'selected' : '' }}>{{$employee['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('person_in_charge')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="contents" class="font-weight-bold">Isi Agenda</label>
                                            <span class="required-field">*</span>
                                            <textarea class="form-control" id="create_contents" name="contents" rows="4" required placeholder="Masukkan Isi Agenda">{{old('contents')}}</textarea>
                                            @error('contents')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="attachment" class="font-weight-bold">Lampiran</label>
                                            <span class="required-field">*</span><br>
                                            <input type="file" id="create_attachment" name="attachment" class="form-control file-upload-default" required accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" max="2048">
                                            <div class="input-group col-xs-12">
                                                <input type="text" id="filename" class="form-control file-upload-info" disabled placeholder="Unggah Lampiran">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Unggah</button>
                                                </span>
                                            </div>
                                            <small id="attachment" class="form-text text-muted">Format yang didukung : pdf, doc, docx, xls, xlsx, zip, jpg, jpeg, png maksimal 2 MB</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="required-field">*) Wajib Diisi</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); validateCreateForm()">Simpan</button>
                            </div>
                        </form>
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

        document.getElementById('create_room_id').addEventListener('change', function() {
            var selectedOption = this.value;
            var textareaContainer = document.getElementById('textareaLocation');
            var endDateInput = document.getElementById('create_end_date');
            
            if (selectedOption === '1') {
                console.log(selectedOption);
                document.getElementById('location_label').innerHTML = 'Detail Link';
            } else {
                document.getElementById('location_label').innerHTML = 'Detail Tempat';
            }

            // Show/hide the textarea based on the selected option
            if (selectedOption === '1' || selectedOption === '2') {
                textareaContainer.style.display = 'block';
                document.getElementById('create_location').required = true;
                endDateInput.required = true;
            } else {
                textareaContainer.style.display = 'none';
                document.getElementById('create_location').required = false;
                endDateInput.required = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the input elements
            var startTimeInput = document.getElementById('create_start_time');
            var endTimeInput = document.getElementById('create_end_time');

            // Add event listener to check time validity on change
            startTimeInput.addEventListener('change', validateEndTime);
            endTimeInput.addEventListener('change', validateEndTime);

            function validateEndTime() {
                var startTime = startTimeInput.value;
                var endTime = endTimeInput.value;

                if (startTime && endTime && endTime < startTime) {
                    endTimeInput.setCustomValidity('Waktu Selesai harus lebih besar dari Waktu Mulai');
                } else {
                    endTimeInput.setCustomValidity('');
                }
            }
        });

        $(document).ready(function() {
            $('#person_in_charge').select2();
        });

        function confirmCreate() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menambahkan agenda? Tindakan ini tidak dapat dibatalkan, pastikan anda sudah mengecek data sebelum menyimpan.',
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

        function validateCreateForm() {
            var title = document.getElementById('create_title').value;
            var date = document.getElementById('create_date').value;
            var room_id = document.getElementById('create_room_id').value;
            var location = document.getElementById('create_location').value;
            var start_time = document.getElementById('create_start_time').value;
            var end_time = document.getElementById('create_end_time').value;
            var disposition_description = document.getElementById('create_disposition_description').value;
            var category_id = document.getElementById('create_category_id').value;
            var department_id = document.getElementById('create_department_id').value;
            var person_in_charge = document.getElementById('create_person_in_charge').value;
            var contents = document.getElementById('create_contents').value;
            var attachment = document.getElementById('create_attachment').value;

            if (title === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Judul Agenda tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (date === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Tanggal tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (room_id === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Tempat harus dipilih!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if ((room_id === '1' || room_id === '2') && location === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Detail Tempat tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if ((room_id !== '1' && room_id !== '2') && end_time === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Waktu Selesai tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (start_time === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Waktu Mulai tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (disposition_description === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Peserta tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (category_id === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Kategori harus dipilih!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (department_id === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Bidang harus dipilih!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (person_in_charge === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Penanggung Jawab harus dipilih!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (contents === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Isi Agenda tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            if (attachment === '') {
                Swal.fire({
                    title: 'Validasi Gagal',
                    text: 'Lampiran tidak boleh kosong!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        icon: 'swal-icon-custom' // Add your custom CSS class here
                    }
                });
                return false;
            }

            confirmCreate();
        }
    
        // Initialize the datepicker
        $( "#copydate" ).datepicker();
    </script>

    <style>
        .required-field {
            color: red;
            margin-left: 5px;
        }
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