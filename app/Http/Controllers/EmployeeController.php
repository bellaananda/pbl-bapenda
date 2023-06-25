<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //show employees
        $search = $request->input('search', null);
        $order = $request->input('order', 'name');
        $sort = $request->input('sort', 'asc');
        $pages = $request->input('pages', 15);
        $currentPage = $request->query('page', 1);

        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role == 'user') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/employees", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'search' => $search,
                'order' => $order,
                'sort' => $sort,
                'pages' => $pages
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        $page = 'pegawai';
        $totalPagination = count($data) / 15;

        $collection = new Collection($data);
        $perPage = $pages;
        $currentPage = request()->get('page', 1);
        $items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($items, $collection->count(), $perPage, $currentPage);

        $responsePosition = $client->request('GET', "{$base_uri}/positions", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $bodyPosition = $responsePosition->getBody();
        $resultPosition = json_decode($bodyPosition, true);
        $positions =  $resultPosition['data'];
        
        $responseDepartment = $client->request('GET', "{$base_uri}/departments", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);
        $bodyDepartment = $responseDepartment->getBody();
        $resultDepartment = json_decode($bodyDepartment, true);
        $departments =  $resultDepartment['data'];

        return view($role.'.employees', compact('page', 'data', 'totalPagination','currentPage', 'token', 'positions', 'departments'));
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
        //create employee (admin)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $request->validate([
            'position_id' => 'required',
            'department_id' => 'required',
            'nip' => 'required|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        try {
            $responseEmail = $client->post("{$base_uri}/validate-email", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'form_params' => [
                    'email' => $request->email
                ],
                'verify' => false
            ]);
            if ($responseEmail->getStatusCode() != 200) {
                return back()->with('error_message', 'Email sudah digunakan!');
            }
        } catch (\Exception $e) {
            return back()->with('error_message', 'Email sudah digunakan!');
        }
        $response = $client->post("{$base_uri}/employees", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'nip' => $request->nip,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 201 && $data['success']) {
            return redirect('/pegawai')->with('success_message', 'Pegawai berhasil ditambahkan!');
        } else {
            return back()->with('error_message', 'Pegawai gagal ditambahkan!');
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
        //update employee (admin)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'admin') {
            return redirect('/');
        }

        $request->validate([
            'position_id' => 'required',
            'department_id' => 'required',
            'nip' => 'required|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/employees/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'id' => $id,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'nip' => $request->nip,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'role' => $request->role,
                'status' => $request->status,
                '_method' => 'put'
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/pegawai')->with('success_message', 'Pegawai berhasil diubah!');
        } else {
            return back()->with('error_message', 'Pegawai gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function passwordReset($id) {
        //update password employee (all)
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
        $response = $client->post("{$base_uri}/employee-password-update/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'id' => $id,
                'new_password' => 'bapenda123'
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/pegawai')->with('success_message', 'Password pegawai berhasil direset!');
        } else {
            return back()->with('error_message', 'Password pegawai gagal direset!');
        }
    }
}
