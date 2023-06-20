@extends('../layouts.operator.app')

@section('main')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin title">
                <div class="row">
                    <div class="col-12 align-items-center">
                        <h3 class="font-weight-bold">GRAFIK BAPENDA SURAKARTA</h3>
                    </div>
                </div>
            </div>
        </div>
        <form action="/grafik" method="post" id="monthForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card-transparent">
                        <div class="card-body">
                            <label for="date" class="font-weight-bold">Pilih Bulan</label>
                            <input type="month" class="form-control" id="date" name="date" value="{{date('Y-m')}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-transparent">
                        <div class="card-body">
                            <label for="room" class="font-weight-bold">Pilih Ruangan</label>
                            <select class="form-control" id="room" name="room" required>
                                <option disabled value selected>Pilih Ruangan</option>
                                @foreach ($rooms_data as $room)
                                    <option {{ old('room', $room_val) == $room['id'] ? 'selected' : '' }} value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Total Agenda</p>
                        </div>
                        <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="agendas-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Total Penggunaan Ruangan</p>
                        </div>
                        <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="rooms-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('asset/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('asset/js/chart.js') }}"></script>

    <script type="text/javascript">
        const form = document.getElementById('monthForm');
        const input1 = document.getElementById('date');
        const input2 = document.getElementById('room');

        input1.addEventListener('change', function () {
            form.submit();
        });
        
        input2.addEventListener('change', function () {
            form.submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the chart data
            var dataAgenda = @json($agendas);
            var labelAgendas = dataAgenda.labels;
            var valueAgendas = dataAgenda.datasets[0].data;
            
            var dataRoom = @json($rooms);
            var labelRooms = dataRoom.labels;
            var valueRooms = dataRoom.datasets[0].data;

            // Create the agenda chart
            var ctxAgenda = document.getElementById('agendas-chart').getContext('2d');
            var myChart = new Chart(ctxAgenda, {
                type: 'bar',
                data: {
                    labels: labelAgendas,
                    datasets: [{
                        label: 'Jumlah Agenda',
                        data: valueAgendas,
                        backgroundColor: 'rgba(75, 73, 172, 1)',
                        borderColor: 'rgba(75, 73, 172, 1)',
                        borderWidth: 0,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            ticks: {
                                maxTicksLimit: null,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Create the room chart
            var ctxRoom = document.getElementById('rooms-chart').getContext('2d');
            var myChart = new Chart(ctxRoom, {
                type: 'bar',
                data: {
                    labels: labelRooms,
                    datasets: [{
                        label: 'Penggunaan Ruangan',
                        data: valueRooms,
                        backgroundColor: 'rgba(75, 73, 172, 1)',
                        borderColor: 'rgba(75, 73, 172, 1)',
                        borderWidth: 0,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            ticks: {
                                maxTicksLimit: null,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection