<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'user') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('get', "{$base_uri}/notify", [
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
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'user') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('post', "{$base_uri}/notify", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'id' => $request->id
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        if ($response->getStatusCode() == 200) {
            return redirect()->back()->with('refresh', true);
        } else {
            return back();
        }
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
