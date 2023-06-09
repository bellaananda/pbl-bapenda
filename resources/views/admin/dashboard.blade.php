@extends('../layouts.admin.app')

@section('title', 'BAPENDA Surakarta')

@section('main')
<div class="main-panel">
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
          <div class="card position-relative">
            <div class="card-body">
              <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">HARI INI</p>
                        </div>  
                      </div>
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
                  <div class="carousel-item">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">BESOK</p>
                        </div>  
                      </div>
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
                                  @foreach ($data_tomorrow as $item)
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
                  <div class="carousel-item">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">KEMARIN</p>
                        </div>  
                      </div>
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
                                  @foreach ($data_yesterday as $item)
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
                <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                  </a>
                    <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection