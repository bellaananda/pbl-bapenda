<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //show agendas (operator, admin)
        $search = $request->input('search', null);
        $order = $request->input('order', 'date');
        $sort = $request->input('sort', 'desc');
        $pages = $request->input('pages', 15);
        $currentPage = $request->query('page', 1);

        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/agendas", [
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
        $role = Session::get('details')['role'];
        $page = 'agenda';
        $fileUrl = "https://api.klikagenda.com/public/uploads/agendas_attachments/";
        $totalPagination = count($data) / 15;

        $collection = new Collection($data);
        $perPage = $pages;
        $currentPage = request()->get('page', 1);
        $items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($items, $collection->count(), $perPage, $currentPage);
        
        if ($role == 'operator') {

            $responseRoom = $client->request('GET', "{$base_uri}/rooms", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'search' => $search,
                    'order' => 'id',
                    'sort' => 'asc',
                    'pages' => $pages
                ],
                'verify' => false
            ]);
            $bodyRoom = $responseRoom->getBody();
            $resultRoom = json_decode($bodyRoom, true);
            $rooms =  $resultRoom['data'];

            $responseCategory = $client->request('GET', "{$base_uri}/categories", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'search' => $search,
                    'order' => 'name',
                    'sort' => 'asc',
                    'pages' => $pages
                ],
                'verify' => false
            ]);
            $bodyCategory = $responseCategory->getBody();
            $resultCategory = json_decode($bodyCategory, true);
            $categories =  $resultCategory['data'];

            $responseDepartment = $client->request('GET', "{$base_uri}/departments", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'search' => $search,
                    'order' => 'id',
                    'sort' => 'asc',
                    'pages' => $pages
                ],
                'verify' => false
            ]);
            $bodyDepartment = $responseDepartment->getBody();
            $resultDepartment = json_decode($bodyDepartment, true);
            $departments =  $resultDepartment['data'];

            $responseEmployee = $client->request('GET', "{$base_uri}/active-employees", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json' => [
                    'search' => $search,
                    'order' => 'name',
                    'sort' => 'asc',
                    'pages' => $pages
                ],
                'verify' => false
            ]);
            $bodyEmployee = $responseEmployee->getBody();
            $resultEmployee = json_decode($bodyEmployee, true);
            $employees =  $resultEmployee['data'];

            return view($role.'.agendas', compact('page', 'fileUrl', 'data', 'totalPagination','currentPage', 'token', 'rooms', 'categories', 'departments', 'employees'));
        }

        return view($role.'.agendas', compact('page', 'fileUrl', 'data', 'totalPagination','currentPage', 'token'));
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
        //store agenda (operator)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }

        $request->validate([
            'department_id' => 'required',
            'category_id' => 'required',
            'room_id' => 'required',
            'person_in_charge' => 'required',
            'title' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required_unless:room_id,1,2',
            'location' => 'required_if:room_id,1,2',
            'contents' => 'required|string',
            'attachment' => 'file|mimes:xls,xlsx,doc,docx,pdf,zip,jpg,jpeg,png|max:2048',
            'disposition_description' => 'required',
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";

        $response = $client->post("{$base_uri}/agendas", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'department_id' => $request->department_id,
                'category_id' => $request->category_id,
                'room_id' => $request->room_id,
                'person_in_charge' => $request->person_in_charge,
                'title' => $request->title,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'contents' => $request->contents,
                'attachment' => $request->file('attachment'),
                'disposition_description' => $request->disposition_description
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/agenda')->with('success_message', 'Agenda berhasil ditambahkan!');
        } else {
            return back()->with('error_message', 'Agenda gagal ditambahkan!');
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
