<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $notification;

    public function __construct(NotificationController $notification)
    {
        $this->notification = $notification;
    }

    public function index(Request $request)
    {
        //show suggestions (user, operator)
        $search = $request->input('search', null);
        $order = $request->input('order', 'date');
        $sort = $request->input('sort', 'desc');
        $pages = $request->input('pages', 15);
        $currentPage = $request->query('page', 1);

        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role == 'admin') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $role = Session::get('details')['role'];
        $res = ($role == 'operator') ? 'suggestions' : 'suggestions-user/' . Session::get('details')['id'];
        $response = $client->request('GET', "{$base_uri}/".$res, [
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
        $page = 'pengajuan';
        $fileUrl = "https://api.klikagenda.com/public/uploads/suggestions_attachments/";
        $totalPagination = count($data) / 15;

        $collection = new Collection($data);
        $perPage = $pages;
        $currentPage = request()->get('page', 1);
        $items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($items, $collection->count(), $perPage, $currentPage);
        
        if ($role == 'user') {
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
            $notify = $this->notification->index();

            return view($role.'.suggestions-history', compact('page', 'fileUrl', 'data', 'totalPagination','currentPage', 'token', 'rooms', 'categories', 'departments', 'employees', 'notify'));
        }

        return view($role.'.suggestions', compact('page', 'fileUrl', 'data', 'totalPagination','currentPage', 'token'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //show create suggestion (user)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'user') {
            return redirect('/');
        }
        $page = 'add_pengajuan';
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";

        $responseRoom = $client->request('GET', "{$base_uri}/rooms", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'order' => 'id',
                'sort' => 'asc',
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
                'order' => 'name',
                'sort' => 'asc',
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
                'order' => 'id',
                'sort' => 'asc',
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
                'order' => 'name',
                'sort' => 'asc',
            ],
            'verify' => false
        ]);
        $bodyEmployee = $responseEmployee->getBody();
        $resultEmployee = json_decode($bodyEmployee, true);
        $employees =  $resultEmployee['data'];
        $notify = $this->notification->index();

        return view('user.suggestions-new', compact('page', 'rooms', 'categories', 'departments', 'employees', 'notify'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //create suggestion (user)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'user') {
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
            'attachment' => 'required|file|mimes:xls,xlsx,doc,docx,pdf,zip,jpg,jpeg,png|max:2048',
            'disposition_description' => 'required',
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";

        $response = $client->post("{$base_uri}/suggestions", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'multipart' => [
                [
                    'name' => 'user_id',
                    'contents' => Session::get('details')['id'],
                ],
                [
                    'name' => 'department_id',
                    'contents' => $request->department_id,
                ],
                [
                    'name' => 'category_id',
                    'contents' => $request->category_id,
                ],
                [
                    'name' => 'room_id',
                    'contents' => $request->room_id,
                ],
                [
                    'name' => 'person_in_charge',
                    'contents' => $request->person_in_charge,
                ],
                [
                    'name' => 'title',
                    'contents' => $request->title,
                ],
                [
                    'name' => 'date',
                    'contents' => $request->date,
                ],
                [
                    'name' => 'start_time',
                    'contents' => $request->start_time,
                ],
                [
                    'name' => 'end_time',
                    'contents' => $request->end_time,
                ],
                [
                    'name' => 'location',
                    'contents' => $request->location,
                ],
                [
                    'name' => 'contents',
                    'contents' => $request->contents,
                ],
                [
                    'name' => 'attachment',
                    'contents' => fopen($request->file('attachment')->getRealPath(), 'r'),
                    'filename' => $request->file('attachment')->getClientOriginalName(),
                ],
                [
                    'name' => 'disposition_description',
                    'contents' => $request->disposition_description,
                ]
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 201 && $data['success']) {
            return redirect('/pengajuan')->with('success_message', 'Agenda berhasil diajukan!');
        } else {
            return back()->with('error_message', 'Agenda gagal diajukan!');
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
        //update suggestion (user)
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'user') {
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
            'attachment' => 'required|file|mimes:xls,xlsx,doc,docx,pdf,zip,jpg,jpeg,png|max:2048',
            'disposition_description' => 'required',
        ]);

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";

        $response = $client->post("{$base_uri}/suggestions/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'multipart' => [
                [
                    'name' => '_method',
                    'contents' => 'put',
                ],
                [
                    'name' => 'department_id',
                    'contents' => $request->department_id,
                ],
                [
                    'name' => 'category_id',
                    'contents' => $request->category_id,
                ],
                [
                    'name' => 'room_id',
                    'contents' => $request->room_id,
                ],
                [
                    'name' => 'person_in_charge',
                    'contents' => $request->person_in_charge,
                ],
                [
                    'name' => 'title',
                    'contents' => $request->title,
                ],
                [
                    'name' => 'date',
                    'contents' => $request->date,
                ],
                [
                    'name' => 'start_time',
                    'contents' => $request->start_time,
                ],
                [
                    'name' => 'end_time',
                    'contents' => $request->end_time,
                ],
                [
                    'name' => 'location',
                    'contents' => $request->location,
                ],
                [
                    'name' => 'contents',
                    'contents' => $request->contents,
                ],
                [
                    'name' => 'attachment',
                    'contents' => fopen($request->file('attachment')->getRealPath(), 'r'),
                    'filename' => $request->file('attachment')->getClientOriginalName(),
                ],
                [
                    'name' => 'disposition_description',
                    'contents' => $request->disposition_description,
                ]
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/pengajuan')->with('success_message', 'Pengajuan agenda berhasil diubah!');
        } else {
            return back()->with('error_message', 'Pengajuan agenda gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approveAgenda($id) {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'operator') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/suggestions-approve/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/pengajuan')->with('success_message', 'Pengajuan berhasil disetujui!');
        } else {
            return back()->with('error_message', 'Pengajuan gagal disetujui!');
        }
    }

    public function denyAgenda(Request $request, $id) {
        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        $role = Session::get('details')['role'];
        if ($role != 'operator') {
            return redirect('/');
        }

        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->post("{$base_uri}/suggestions-deny/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => ['notes' => $request->input('notes')],
            'verify' => false
        ]);

        $data = json_decode($response->getBody(), true);
    
        if ($response->getStatusCode() == 200 && $data['success']) {
            return redirect('/pengajuan')->with('success_message', 'Pengajuan berhasil ditolak!');
        } else {
            return back()->with('error_message', 'Pengajuan gagal ditolak!');
        }
    }
}
