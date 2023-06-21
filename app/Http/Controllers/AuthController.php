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
    protected $notification;

    public function __construct(NotificationController $notification)
    {
        $this->notification = $notification;
    }

    public function index()
    {
        //login page
        $token = Session::get('access_token');

        if ($token) {
            return redirect('/')->with('error_message', 'Anda sudah login!');
        }
        $page = 'login';
        return view('login', compact('page'));
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
        //login
        $request->validate([
            'email' => 'required|string|max:150|email',
            'password' => 'required|string|min:8'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        try {
            $response = $client->post("{$base_uri}/login", [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ],
                'verify' => false
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            if ($response->getStatusCode() == 200 && $data['success']) {
                $user = $data['id'];
                $token = $data['access_token'];
    
                session(['user' => $user]);
                session(['access_token' => $token]);
                $details = $this->getUserDetails();
                session(['details' => $details]);
    
                return redirect('/')->with('success_message', 'Login berhasil!');
            }
        } catch (\Exception $e) {
            // API request failed or response error
            return back()->with('error_message', 'Login gagal! Silakan cek email atau password.');
        }
        return back()->with('error_message', 'Login gagal! Silakan cek email atau password.');
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
        //logout
        $user = Session::get('user');
        $token = Session::get('access_token');

        if (!$token) {
            return back()->with('error_message', 'Logout gagal! Anda tidak login.');
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
        return redirect('/')->with('success_message', 'Logout berhasil!');
    }

    public function getUserDetails() {
        //get user detail
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

    public function getProfile() {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/')->with('error_message', 'Anda tidak login!');
        }

        $page = 'profil';
        $id = Session::get('details')['id'];
        $role = Session::get('details')['role'];
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->get("{$base_uri}/employees/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $data = json_decode($response->getBody(), true)['data'][0];
        $notify = $this->notification->index();
        return view($role.'.profile', compact('page', 'notify', 'data'));
    }

    public function changePassword(Request $request) {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/')->with('error_message', 'Anda tidak login!');
        }

        $id = Session::get('details')['id'];
        $password = $request->input('password');
        $password_confirm = $request->input('password_confirm');
        if ($password != $password_confirm) {
            return back()->with('error_message', 'Password gagal diubah!');
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/employee-password-update/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'new_password' => $password
            ],
            'verify' => false
        ]);
        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            Session::flush();
            return redirect('/')->with('success_message', 'Password berhasil diubah!');
        } else {
            return back()->with('error_message', 'Password gagal diubah!');
        }
    }
}
