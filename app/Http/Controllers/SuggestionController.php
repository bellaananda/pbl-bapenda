<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 15);
        $data = DB::table('suggestions')
                ->join('users', 'suggestions.user_id', '=', 'users.id')
                ->join('departments', 'suggestions.department_id', '=', 'departments.id')
                ->join('categories', 'suggestions.category_id', '=', 'categories.id')
                ->join('rooms', 'suggestions.room_id', '=', 'rooms.id')
                ->select(
                    'suggestions.id', 
                    'suggestions.title', 
                    'suggestions.date', 
                    'suggestions.start_time', 
                    'suggestions.end_time', 
                    DB::raw("(CASE WHEN ISNULL(location) THEN rooms.name ELSE suggestions.location END) AS location"),
                    'suggestions.contents', 
                    'suggestions.attachment', 
                    'suggestions.status', 
                    DB::raw('users.name AS user'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw('users.name AS person_in_charge')
                )
                ->orderBy($order, $sort)->paginate($page);
        if ($search != null) {
            $data = DB::table('suggestions')
                    ->join('users', 'suggestions.user_id', '=', 'users.id')
                    ->join('departments', 'suggestions.department_id', '=', 'departments.id')
                    ->join('categories', 'suggestions.category_id', '=', 'categories.id')
                    ->join('rooms', 'suggestions.room_id', '=', 'rooms.id')
                    ->select(
                        'suggestions.id', 
                        'suggestions.title', 
                        'suggestions.date', 
                        'suggestions.start_time', 
                        'suggestions.end_time', 
                        DB::raw("(CASE WHEN ISNULL(location) THEN rooms.name ELSE suggestions.location END) AS location"),
                        'suggestions.contents', 
                        'suggestions.attachment', 
                        DB::raw("(CASE WHEN suggestions.status = 1 THEN 'Diterima' WHEN suggestions.status = 0 THEN 'Diproses' ELSE 'Ditolak' END) AS status"),
                        DB::raw('users.name AS user'), 
                        DB::raw('departments.name AS department'),
                        DB::raw('categories.name AS category'),
                        DB::raw('users.name AS person_in_charge')
                    )
                    ->where('suggestions.title', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.date', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.start_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.end_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.location', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.contents', 'LIKE', '%' . $search .'%')
                    ->orWhere('users.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('departments.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('categories.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('rooms.name', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Pengajuan Agenda',
            'data'    => $data  
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'department_id' => 'required',
            'category_id' => 'required',
            'room_id' => '',
            'person_in_charge' => 'required',
            'title' => 'required|string',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => '',
            'location' => '',
            'contents' => 'required|string',
            'attachment' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Suggestion::create([
            'user_id' => $request->user_id,
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
            'attachment' => $request->attachment,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan agenda baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pengajuan agenda baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Suggestion::find($id)
                ->join('users', 'suggestions.user_id', '=', 'users.id')
                ->join('departments', 'suggestions.department_id', '=', 'departments.id')
                ->join('categories', 'suggestions.category_id', '=', 'categories.id')
                ->join('rooms', 'suggestions.room_id', '=', 'rooms.id')
                ->select(
                    'suggestions.id', 
                    'suggestions.title', 
                    'suggestions.date', 
                    'suggestions.start_time', 
                    'suggestions.end_time', 
                    'suggestions.location', 
                    'suggestions.contents', 
                    'suggestions.attachment', 
                    'suggestions.status',
                    DB::raw("(CASE WHEN suggestions.status = 1 THEN 'Diterima' WHEN suggestions.status = 0 THEN 'Diproses' ELSE 'Ditolak' END) AS status"),
                    DB::raw('users.name AS user'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw('rooms.name AS room'),
                    DB::raw('users.name AS person_in_charge')
                )->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data pengajuan agenda!',
            'data'    => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Suggestion $suggestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuggestionRequest  $request
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Suggestion::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda tidak ditemukan!'
            ], 404);
        }

        //if
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'department_id' => 'required',
            'category_id' => 'required',
            'room_id' => '',
            'person_in_charge' => 'required',
            'title' => 'required|string',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => '',
            'location' => '',
            'contents' => 'required|string',
            'attachment' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'user_id' => $request->user_id,
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
            'attachment' => $request->attachment,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data pengajuan agenda berhasil diubah!',
            'data'    => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Suggestion::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data pengajuan agenda berhasil dihapus!'
        ], 200);
    }

    public function approveAgenda($id) {
        $data = Suggestion::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda tidak ditemukan!'
            ], 404);
        }

        $data->status = 1;
        $data->save();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Status pengajuan agenda gagal disetujui!'
            ], 409);
        }
        $agenda = Agenda::create([
            'department_id' => $data->department_id,
            'category_id' => $data->category_id,
            'room_id' => $data->room_id,
            'suggestion_id' => $data->id,
            'person_in_charge' => $data->person_in_charge,
            'title' => $data->title,
            'date' => $data->date,
            'start_time' => $data->start_time,
            'end_time' => $data->end_time,
            'location' => $data->location,
            'contents' => $data->contents,
            'attachment' => $data->attachment,
        ]);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status pengajuan agenda berhasil disetujui! Data agenda berhasil ditambahkan!',
            'data'    => $data
        ], 200);
    }

    public function denyAgenda($id) {
        $data = Suggestion::find($id);
        if (!$data) {



            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan agenda tidak ditemukan!'
            ], 404);
        }

        $data->status = 2;
        $data->save();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Status pengajuan agenda gagal ditolak!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status pengajuan agenda berhasil ditolak!',
            'data'    => $data
        ], 200);
    }
}
