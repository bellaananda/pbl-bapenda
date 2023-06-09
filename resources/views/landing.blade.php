@extends('../layouts.app')

@section('title', 'BAPENDA Surakarta')

@section('main')
    <div style="width: 100%;" class="main-panel">
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
                                            <th>Lokasi</th>
                                            <th>Disposisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1}}</td>
                                                <td>{{ $item['title'] }}</td>
                                                <td>{{ $item['date'] }}</td>
                                                @if ($item['end_time'] != null)
                                                    <td>{{ $item['start_time'] . ' - ' . $item['end_time'] }}</td>
                                                @else
                                                    <td>{{ $item['start_time'] }}</td>                                            
                                                @endif
                                                <td>{{ $item['location'] }}</td>
                                                <td>{{ $item['location'] }}</td>
                                                <td>{{ $item['disposition'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection
