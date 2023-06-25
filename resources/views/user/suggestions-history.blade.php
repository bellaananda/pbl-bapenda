@extends('../layouts.user.app')

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
            <div class="row">
                <div class="col-md-12 grid-margin title">
                    <div class="row">
                        <div class="col-12 align-items-center">
                            <h3 class="font-weight-bold">RIWAYAT PENGAJUAN AGENDA</h3>
                        </div>
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
                                            <th>Tanggal Pengajuan</th>
                                            <th>Judul Agenda</th>
                                            <th>Tanggal Agenda</th>
                                            <th>Waktu</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Status</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ ($loop->index + 1) + 15*($currentPage-1) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item['suggestion_date'])) }}</td>
                                                <td class="max-width-column">{{$item['title']}}</td>
                                                <td>{{ date('d-m-Y', strtotime($item['date'])) }}</td>
                                                @if ($item['end_time'] != null)
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) . ' - ' . date('H:i', strtotime($item['end_time'])) }}</td>
                                                @else
                                                    <td>{{ date('H:i', strtotime($item['start_time'])) }}</td>                                            
                                                @endif
                                                <td class="max-width-column">{{$item['person_in_charge_name']}}</td>
                                                <td>
                                                    @if ($item['status'] == 1)
                                                        <span class="badge badge-success">{{$item['status_name']}}</span>
                                                    @elseif ($item['status'] == 3)
                                                        <span class="badge badge-info">{{$item['status_name']}}</span>
                                                    @elseif ($item['status'] == 0)
                                                        <span class="badge badge-warning">{{$item['status_name']}}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{$item['status_name']}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal{{$loop->index}}">
                                                        <i class="mdi mdi-magnify btn-icon-prepend"></i>
                                                    </a>
                                                </td>
                                                @if ($item['status'] == 2)
                                                    <td>
                                                        <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$loop->index}}">
                                                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                            <div class="modal fade" id="detailModal{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true"> 
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title display-5" id="detailModalLabel">Detail Pengajuan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if ($item['notes_of_refusal'] != null)
                                                                        <div class="form-group">
                                                                            <label for="notes" class="font-weight-bold">Catatan Penolakan</label>
                                                                            <textarea class="form-control" id="notes" name="notes" rows="4" disabled>{{ $item['notes_of_refusal'] }}</textarea>
                                                                        </div>
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <label for="title" class="font-weight-bold">Judul Agenda</label>
                                                                        <input type="text" class="form-control" id="title" name="title" value="{{$item['title']}}" disabled/>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="date" class="font-weight-bold">Tanggal Pengajuan</label>
                                                                                <input type="date" class="form-control" id="date" value="{{$item['suggestion_date']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="date" class="font-weight-bold">Tanggal Agenda</label>
                                                                                <input type="date" class="form-control" id="date" value="{{$item['date']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="room_id" class="font-weight-bold">Tempat</label>
                                                                        <textarea class="form-control" id="location" name="location" rows="4" disabled>{{ $item['location_name'] }}</textarea>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="start_time" class="font-weight-bold">Waktu Mulai</label>
                                                                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{$item['start_time']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="end_time" class="font-weight-bold">Waktu Selesai</label>
                                                                                <input type="time" class="form-control" id="end_time" name="end_time" value="{{$item['end_time']}}" disabled/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="disposition_description" class="font-weight-bold">Peserta</label>
                                                                        <textarea class="form-control" id="disposition_description" name="disposition_description" rows="4" disabled>{{$item['disposition']}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="category_id" class="font-weight-bold">Kategori</label>
                                                                        <input type="text" class="form-control" name="category_id" id="category_id" value="{{$item['category']}}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="department_id" class="font-weight-bold">Bidang</label>
                                                                        <input type="text" class="form-control" name="department_id" id="department_id" value="{{$item['department']}}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="person_in_charge" class="font-weight-bold">Penanggung Jawab</label>
                                                                        <input type="text" class="form-control" name="person_in_charge" id="person_in_charge" value="{{$item['person_in_charge_name']}}" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="contents" class="font-weight-bold">Isi Agenda</label>
                                                                        <textarea class="form-control" id="contents" name="contents" rows="4" disabled>{{$item['contents']}}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="attachment" class="font-weight-bold">Lampiran</label><br>
                                                                        @if (substr(strrchr($item['attachment'], '.'), 1) == 'PDF')
                                                                            <embed id="attachment" src="{{ $fileUrl.$item['attachment'] }}" width="600px" height="150px" />
                                                                        @elseif (substr(strrchr($item['attachment'], '.'), 1) == 'jpg' || substr(strrchr($item['attachment'], '.'), 1) == 'jpeg' || substr(strrchr($item['attachment'], '.'), 1) == 'png')
                                                                            <img src="{{ $fileUrl.$item['attachment'] }}" alt="File Preview" style="max-width: 600px; max-height: 200px;">
                                                                        @endif
                                                                        <br>
                                                                        <a href="{{ $fileUrl.$item['attachment'] }}" download="{{ $item['attachment'] }}">Unduh Lampiran</a>
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
                                                            <h5 class="modal-title display-5" id="editModalLabel">Ubah Detail Pengajuan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="/pengajuan/{{$item['id']}}" method="post" enctype="multipart/form-data" id="updateForm{{ $item['id'] }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="title" class="font-weight-bold">Judul Agenda</label>
                                                                            <span class="required-field">*</span><br>
                                                                            <input type="text" class="form-control" id="title{{ $item['id'] }}" name="title" value="{{old('title', $item['title'])}}" placeholder="Masukkan Judul Agenda" required/>
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="date" class="font-weight-bold">Tanggal</label>
                                                                            <span class="required-field">*</span><br>
                                                                            <input type="date" class="form-control" id="date{{ $item['id'] }}" name="date" value="{{old('date',$item['date']) ?? date('Y-m-d')}}" required/>
                                                                            @error('date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="room_id" class="font-weight-bold">Tempat</label>
                                                                            <span class="required-field">*</span><br>
                                                                            <select class="form-control" id="room_id{{ $item['id'] }}" name="room_id" required>
                                                                                <option disabled value selected>Pilih Tempat</option>
                                                                                @foreach ($rooms as $room)
                                                                                    <option value="{{$room['id']}}" {{ old('room_id', $item['room_id']) == $room['id'] ? 'selected' : '' }}>{{$room['name']}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('room_id')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group" id="textareaLocation{{ $item['id'] }}" style="display: none;">
                                                                            <label for="location" id="location_label{{ $item['id'] }}" class="font-weight-bold"></label>
                                                                            <span class="required-field">*</span><br>
                                                                            <textarea class="form-control" id="location{{ $item['id'] }}" name="location" rows="4" placeholder="Masukkan Detail Tempat" required>{{ old('location', $item['location']) }}</textarea>
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
                                                                                    <span class="required-field">*</span><br>
                                                                                    <input type="time" class="form-control" id="start_time{{ $item['id'] }}" name="start_time" value="{{old('start_time', $item['start_time'])}}" required/>
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
                                                                                    <span class="required-field">*</span><br>
                                                                                    <input type="time" class="form-control" id="end_time{{ $item['id'] }}" name="end_time" value="{{old('end_time', $item['end_time'])}}"/>
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
                                                                            <span class="required-field">*</span><br>
                                                                            <textarea class="form-control" id="disposition_description{{ $item['id'] }}" name="disposition_description" rows="4" required placeholder="Masukkan Peserta Agenda">{{old('disposition_description', $item['disposition'])}}</textarea>
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
                                                                            <span class="required-field">*</span><br>
                                                                            <select class="form-control" id="category_id{{ $item['id'] }}" name="category_id" required>
                                                                                <option disabled value selected>Pilih Kategori</option>
                                                                                @foreach ($categories as $category)
                                                                                    <option value="{{$category['id']}}" {{ old('category_id', $item['category_id']) == $category['id'] ? 'selected' : '' }}>{{$category['name']}}</option>
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
                                                                            <span class="required-field">*</span><br>
                                                                            <select class="form-control" id="department_id{{ $item['id'] }}" name="department_id" required>
                                                                                <option disabled value selected>Pilih Bidang</option>
                                                                                @foreach ($departments as $department)
                                                                                    <option value="{{$department['id']}}" {{ old('department_id', $item['department_id']) == $department['id'] ? 'selected' : '' }}>{{$department['name']}}</option>
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
                                                                            <span class="required-field">*</span><br>
                                                                            <select class="form-control" id="person_in_charge{{ $item['id'] }}" name="person_in_charge" required>
                                                                                <option value="" selected disabled>Pilih Penanggung Jawab</option>
                                                                                @foreach ($employees as $employee)
                                                                                    <option value="{{$employee['id']}}" {{ old('person_in_charge', $item['person_in_charge']) == $employee['id'] ? 'selected' : '' }}>{{$employee['name']}}</option>
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
                                                                            <span class="required-field">*</span><br>
                                                                            <textarea class="form-control" id="contents{{ $item['id'] }}" name="contents" rows="4" required placeholder="Masukkan Isi Agenda">{{old('contents', $item['contents'])}}</textarea>
                                                                            @error('contents')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="attachment" class="font-weight-bold">Lampiran</label>
                                                                            <span class="required-field">*</span><br>
                                                                            <input type="file" id="attachment{{ $item['id'] }}" name="attachment" class="form-control file-upload-default" required accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" max="2048">
                                                                            <div class="input-group col-xs-12">
                                                                                <input type="text" id="filename" class="form-control file-upload-info" disabled placeholder="Unggah Lampiran">
                                                                                <span class="input-group-append">
                                                                                    <button class="file-upload-browse btn btn-primary" type="button">Unggah</button>
                                                                                </span>
                                                                            </div>
                                                                            <small id="attachment" class="form-text text-muted">Format yang didukung : pdf, doc, docx, xls, xlsx, zip, jpg, jpeg, png maksimal 2 MB</small>
                                                                            @error('attachment')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required-field">*) Wajib Diisi</label>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                                                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); validateUpdateForm('{{ $item['id'] }}')">Simpan</button>
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
                        <li><a href="/pengajuan?page={{$i+1}}" class="@if($i+1==$currentPage) active @endif">{{$i+1}}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <script src="{{asset('./asset/js/file-upload.js')}}"></script>

    <script>
        @foreach ($data as $item)
            document.getElementById('room_id{{ $item['id'] }}').addEventListener('change', function() {
                var selectedOption = this.value;
                var textareaContainer = document.getElementById('textareaLocation{{ $item['id'] }}');
                var endDateInput = document.getElementById('end_date{{ $item['id'] }}');
                var locationLabel = document.getElementById('location_label{{ $item['id'] }}');

                if (selectedOption === '1') {
                    locationLabel.innerHTML = 'Detail Link';
                } else {
                    locationLabel.innerHTML = 'Detail Tempat';
                }

                // Show/hide the textarea based on the selected option
                if (selectedOption === '1' || selectedOption === '2') {
                    textareaContainer.style.display = 'block';
                    document.getElementById('location{{ $item['id'] }}').required = true;
                    endDateInput.required = true;
                } else {
                    textareaContainer.style.display = 'none';
                    document.getElementById('location{{ $item['id'] }}').required = false;
                    endDateInput.required = false;
                }
            });

            // Check the initial state of room_id
            // var selectedRoom = document.getElementById('room_id{{ $item['id'] }}').value;
            // var textareaContainer = document.getElementById('textareaLocation{{ $item['id'] }}');
            // var locationLabel = document.getElementById('location_label{{ $item['id'] }}');
            // var endDateInput = document.getElementById('end_date{{ $item['id'] }}');

            // if (selectedRoom === '1') {
            //     console.log(selectedRoom);
            //     locationLabel.innerHTML = 'Detail Link';
            //     textareaContainer.style.display = 'block';
            //     document.getElementById('location{{ $item['id'] }}').required = true;
            //     endDateInput.required = true;
            // } else if (selectedRoom === '2') {
            //     console.log(selectedRoom);
            //     locationLabel.innerHTML = 'Detail Tempat';
            //     textareaContainer.style.display = 'block';
            //     document.getElementById('location{{ $item['id'] }}').required = true;
            //     endDateInput.required = true;
            // } else {
            //     textareaContainer.style.display = 'none';
            //     document.getElementById('location{{ $item['id'] }}').required = false;
            //     endDateInput.required = true; // Make end_time required when no location is shown
            // }

            document.addEventListener('DOMContentLoaded', function() {
                // Get the input elements
                var startTimeInput = document.getElementById('start_time{{ $item['id'] }}');
                var endTimeInput = document.getElementById('end_time{{ $item['id'] }}');

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
                $('#person_in_charge{{ $item['id'] }}').select2();
            });
        @endforeach

        function confirmUpdate(itemId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin untuk menyimpan perubahan data pengajuan agenda?',
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

        function validateUpdateForm(itemId) {
            var title = document.getElementById('title'+itemId).value;
            var date = document.getElementById('date'+itemId).value;
            var room_id = document.getElementById('room_id'+itemId).value;
            var location = document.getElementById('location'+itemId).value;
            var start_time = document.getElementById('start_time'+itemId).value;
            var end_time = document.getElementById('end_time'+itemId).value;
            var disposition_description = document.getElementById('disposition_description'+itemId).value;
            var category_id = document.getElementById('category_id'+itemId).value;
            var department_id = document.getElementById('department_id'+itemId).value;
            var person_in_charge = document.getElementById('person_in_charge'+itemId).value;
            var contents = document.getElementById('contents'+itemId).value;
            var attachment = document.getElementById('attachment'+itemId).value;

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

            confirmUpdate(itemId);
        }

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