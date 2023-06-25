<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //show categories
        $search = $request->input('search', null);

        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/categories", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'search' => $search
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        $page = 'kategori';

        return view($role.'.categories', compact('page', 'data'));
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
        //create category (admin)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        try {
            $responseValidate = $client->post("{$base_uri}/validate-category", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'form_params' => [
                    'name' => $request->name
                ],
                'verify' => false
            ]);
            if ($responseValidate->getStatusCode() != 200) {
                return back()->with('error_message', 'Nama sudah digunakan!');
            }
        } catch (\Exception $e) {
            return back()->with('error_message', 'Nama sudah digunakan!');
        }
        $response = $client->post("{$base_uri}/categories", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'name' => $request->name
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 201 && $data['success']) {
            return redirect('/kategori')->with('success_message', 'Kategori berhasil ditambahkan!');
        } else {
            return back()->with('error_message', 'Kategori gagal ditambahkan!');
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
        //update category (admin)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        try {
            $responseValidate = $client->post("{$base_uri}/validate-category", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'form_params' => [
                    'name' => $request->name
                ],
                'verify' => false
            ]);
            if ($responseValidate->getStatusCode() != 200) {
                return back()->with('error_message', 'Nama sudah digunakan!');
            }
        } catch (\Exception $e) {
            return back()->with('error_message', 'Nama sudah digunakan!');
        }
        $response = $client->post("{$base_uri}/categories/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'name' => $request->name,
                '_method' => 'put'
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/kategori')->with('success_message', 'Kategori berhasil diubah!');
        } else {
            return back()->with('error_message', 'Kategori gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete category (admin)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/categories/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'id' => $id,
                '_method' => 'delete'
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/kategori')->with('success_message', 'Kategori berhasil dihapus!');
        } else {
            return back()->with('error_message', 'Kategori gagal dihapus!');
        }
    }
}
