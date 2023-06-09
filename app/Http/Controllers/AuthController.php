<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = Session::get('access_token');

        if ($token) {
            return redirect('/');
        }
        return view('login');
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
        $request->validate([
            'email' => 'required|string|max:150|email',
            'password' => 'required|string|min:8'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/login", [
            'form_params' => [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
        $user = $data['id'];
        $token = $data['access_token'];

        if (isset($data['access_token'])) {
            session(['user' => $user]);
            session(['access_token' => $token]);
            $details = $this->getUserDetails();
            session(['details' => $details]);
            return redirect('/')->with('success_message', 'Login berhasil!');
        } else {
            return back()->with('error_message', 'Login gagal! Silakan cek email atau password.');
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
    public function destroy()
    {
        $user = Session::get('user');
        $token = Session::get('access_token');

        if (!$token) {
            return null;
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/logout", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        if (!$response) {
            return back()->with('error_message', 'Logout gagal!');
        }
        Session::flush();
        return redirect('/')->with('success_message', 'Logout gagal!');
    }

    public function getUserDetails() {
        $user = Session::get('user');
        $token = Session::get('access_token');

        if (!$token) {
            return null;
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->get("{$base_uri}/employees/{$user}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        if (!$response) {
            return null;
        }
        $data = json_decode($response->getBody(), true);
        return $data['data'][0];
    }
}
