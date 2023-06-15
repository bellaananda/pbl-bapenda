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
        $search = $request->input('search', null);
        $order = $request->input('order', 'date');
        $sort = $request->input('sort', 'desc');
        $pages = $request->input('pages', 15);
        $currentPage = $request->query('page', 1);

        $token = Session::get('access_token');
        if ($token == null) {
            return redirect('/');
        }
        setlocale (LC_TIME, 'id_ID');
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
