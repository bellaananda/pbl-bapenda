@extends('../layouts.app')

@section('title', 'BAPENDA Surakarta')

@section('main')
    <div style="width: 100%" class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin title">
                    <div class="row">
                        <div class="col-12 align-items-center">
                            <h3 class="font-weight-bold">AGENDA BAPENDA SURAKARTA</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <!-- <div class="brand-logo">
                                    <img src="asset/images/logo-bapenda.svg" alt="logo" />
                                </div> -->
                                <h3>Form Login</h3>
                                <h6 class="font-weight-light">Masukkan email dan password untuk dapat login</h6>
                                <form action="/login" method="post" class="pt-3" @submit.prevent="login">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" value="{{ old('password') }}" required />
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
                <div class="col-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="ml-xl-4 mt-3">
                            <p class="card-title">AGENDA HARI INI</p>
                        </div>
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
                                                <td>{{ $loop->index + 1}}</td>
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
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal{{ $loop->index }}">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="detailModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $loop->index }}" aria-hidden="true"> 
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
        </div>
    <!-- <Footer /> -->
    </div>  

    <style>
        .max-width-column {
            max-width: 200px; /* Ubah nilai sesuai kebutuhan */
            white-space: nowrap; /* Untuk mencegah pemotongan teks */
            overflow: hidden; /* Untuk menyembunyikan konten yang terpotong */
            text-overflow: ellipsis; /* Untuk menampilkan tanda elipsis (...) jika terpotong */
        }
    </style>
@endsection