<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $notificationController;
    protected $reportController;

    public function __construct(NotificationController $notificationController, ReportController $reportController)
    {
        $this->notificationController = $notificationController;
        $this->reportController = $reportController;
    }

    public function index()
    {   
        //landing page, dashboard
        $token = Session::get('access_token');
        $fileUrl = "https://api.klikagenda.com/public/uploads/agendas_attachments/";
        $base_uri = "https://api.klikagenda.com/api";
        $data =  $this->getTodayAgendas($base_uri);
        if ($token == null) {
            $page = 'landing';
            return view('landingpage', compact('data', 'fileUrl', 'page'));
        }
        $data_yesterday = $this->getYesterdayAgendas($token, $base_uri);
        $data_tomorrow =  $this->getTomorrowAgendas($token, $base_uri);
        $role = Session::get('details')['role'];
        $page = 'dashboard';
        if ($role == 'user') {
            $notify = $this->notificationController->index();
            return view($role.'.dashboard', compact('fileUrl', 'data', 'data_yesterday', 'data_tomorrow', 'page', 'notify'));
        }
        $agendasGraph = $this->getAgendasGraph($token);
        $roomGraph = $this->getRoomGraph($token, 3);
        return view($role.'.dashboard', compact('fileUrl', 'data', 'data_yesterday', 'data_tomorrow', 'page', 'agendasGraph', 'roomGraph'));
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

    public function getTodayAgendas($base_uri) {
        $client = new Client;
        $response = $client->request('GET', "{$base_uri}/agendas-today", ['verify' => false]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        return $data;
    }

    public function getYesterdayAgendas($token, $base_uri) {
        $client = new Client;
        $response = $client->request('GET', "{$base_uri}/agendas-yesterday", [
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

    public function getTomorrowAgendas($token, $base_uri) {
        $client = new Client;
        $response = $client->request('GET', "{$base_uri}/agendas-tomorrow", [
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

    function getAgendasGraph($token) {
        $year = date('Y');
        $month = date('m');
        $dataAgenda = $this->reportController->showMonthlyAgenda($token, $year, $month);
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
        return $agendas;
    }

    function getRoomGraph($token, $room) {
        $year = date('Y');
        $month = date('m');
        $dataRoom = $this->reportController->showMonthlyRoom($token, $year, $month, $room);
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
        return $rooms;
    }
}
