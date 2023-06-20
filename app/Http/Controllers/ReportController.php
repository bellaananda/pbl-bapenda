<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }

        $role = Session::get('details')['role'];
        $page = 'grafik';
        $room_val = $request->input('room') ? $request->input('room') : null;
        //default value
        $selected = $request->input('date', date('Y-m'));
        $array = explode("-", $selected);
        $year = $array[0];
        $month = $array[1];
        $room = $request->input('room', 3);

        //get data agenda, rooms
        $rooms_data = $this->showRooms($token);
        $rooms_data = array_slice($rooms_data, 2);
        $dataAgenda = $this->showMonthlyAgenda($token, $year, $month);
        $dataRoom = $this->showMonthlyRoom($token, $year, $month, $room);

        $labelAgendas = array_column($dataAgenda, 'day');
        $valueAgendas = array_column($dataAgenda, 'agenda_count');
        $agendas = [
            'labels' => $labelAgendas,
            'datasets' => [
                [
                    'label' => 'Grafik Agenda',
                    'data' => $valueAgendas
                ],
            ],
        ];

        $labelRooms = array_column($dataRoom, 'day');
        $valueRooms = array_column($dataRoom, 'agenda_count');
        $rooms = [
            'labels' => $labelRooms,
            'datasets' => [
                [
                    'label' => 'Grafik Ruangan',
                    'data' => $valueRooms,
                ],
            ],
        ];

        return view($role.'.graph', compact('page', 'room_val', 'rooms_data', 'agendas', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showRooms($token) {
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/rooms", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        return $data;
    }

    public function showMonthlyAgenda($token, $year, $month) {
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('POST', "{$base_uri}/agendas-graph", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'year' => $year,
                'month' => $month
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        return $data;
    }

    public function showMonthlyRoom($token, $year, $month, $room) {
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('POST', "{$base_uri}/rooms-graph", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'year' => $year,
                'month' => $month,
                'room' => $room
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        return $data;
    }
}
