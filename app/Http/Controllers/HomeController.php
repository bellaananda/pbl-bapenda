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
    protected $notification;

    public function __construct(NotificationController $notification)
    {
        $this->notification = $notification;
    }

    public function index()
    {   
        //landing page, dashboard
        $token = Session::get('access_token');
        Carbon::setLocale('id');
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/agendas-today", ['verify' => false]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        $fileUrl = "https://api.klikagenda.com/public/uploads/agendas_attachments/";
        if ($token == null) {
            $page = 'landing';
            return view('landing', compact('data', 'fileUrl', 'page'));
        }
        $client_yesterday = new Client;
        $response_yesterday = $client_yesterday->request('GET', "{$base_uri}/agendas-yesterday", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $body_yesterday = $response_yesterday->getBody();
        $result_yesterday = json_decode($body_yesterday, true);
        $data_yesterday =  $result_yesterday['data'];
        $client_tomorrow = new Client;
        $response_tomorrow = $client->request('GET', "{$base_uri}/agendas-tomorrow", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $body_tomorrow = $response_tomorrow->getBody();
        $result_tomorrow = json_decode($body_tomorrow, true);
        $data_tomorrow =  $result_tomorrow['data'];
        $role = Session::get('details')['role'];
        $page = 'dashboard';
        if ($role == 'user') {
            $notify = $this->notification->index();
            return view($role.'.dashboard', compact('data', 'fileUrl', 'data_yesterday', 'data_tomorrow', 'page', 'notify'));
        }
        return view($role.'.dashboard', compact('data', 'fileUrl', 'data_yesterday', 'data_tomorrow', 'page'));
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
}
