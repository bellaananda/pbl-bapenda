@extends('../layouts.user.app')

@section('title', 'BAPENDA Surakarta')

@section('additional')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="font-weight-bold">PENGAJUAN AGENDA</h3>
            <div class="row pt-3">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <form action="/pengajuan" method="post" id="createForm" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="font-weight-bold">Judul Agenda</label>
                                            <span class="required-field">*</span><br>
                                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="Masukkan Judul Agenda" required/>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="date" class="font-weight-bold">Tanggal</label>
                                            <span class="required-field">*</span><br>
                                            <input type="date" class="form-control" id="date" name="date" value="{{old('date') ?? date('Y-m-d')}}" required/>
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="room_id" class="font-weight-bold">Tempat</label>
                                            <span class="required-field">*</span><br>
                                            <select class="form-control" id="room_id" name="room_id" required>
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
                                            <label for="location" class="font-weight-bold">Detail Tempat</label>
                                            <span class="required-field">*</span><br>
                                            <textarea class="form-control" id="location" name="location" rows="4" placeholder="Masukkan Detail Tempat" required>{{ old('location') }}</textarea>
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
                                                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{old('start_time')}}" required/>
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
                                                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{old('end_time')}}"/>
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
                                            <textarea class="form-control" id="disposition_description" name="disposition_description" rows="4" required placeholder="Masukkan Peserta Agenda">{{old('disposition_description')}}</textarea>
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
                                            <select class="form-control" id="category_id" name="category_id" required>
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
                                            <span class="required-field">*</span><br>
                                            <select class="form-control" id="department_id" name="department_id" required>
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
                                            <span class="required-field">*</span><br>
                                            <select class="form-control" id="person_in_charge" name="person_in_charge" required>
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
                                            <span class="required-field">*</span><br>
                                            <textarea class="form-control" id="contents" name="contents" rows="4" required placeholder="Masukkan Isi Agenda">{{old('contents')}}</textarea>
                                            @error('contents')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="attachment" class="font-weight-bold">Lampiran</label>
                                            <span class="required-field">*</span><br>
                                            <input type="file" id="attachment" name="attachment" class="form-control file-upload-default" required accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" max="2048">
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
                                <div class="form-group pb-3">
                                    <button type="submit" class="btn btn-primary float-right" onclick="event.preventDefault(); confirmCreate()">Ajukan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
        document.getElementById('room_id').addEventListener('change', function() {
            var selectedOption = this.value;
            var textareaContainer = document.getElementById('textareaLocation');
            var endDateInput = document.getElementById('end_date');

            // Show/hide the textarea based on the selected option
            if (selectedOption === '1' || selectedOption === '2') {
                textareaContainer.style.display = 'block';
                document.getElementById('location').required = true;
                endDateInput.required = true;
            } else {
                textareaContainer.style.display = 'none';
                document.getElementById('location').required = false;
                endDateInput.required = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the input elements
            var startTimeInput = document.getElementById('start_time');
            var endTimeInput = document.getElementById('end_time');

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
                text: 'Anda yakin untuk mengajukan agenda? Tindakan ini tidak dapat dibatalkan, pastikan anda sudah mengecek data sebelum menyimpan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ajukan',
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