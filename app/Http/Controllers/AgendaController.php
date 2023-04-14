<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //agendah where date
        $search = $request->search;
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    'agendas.start_time', 
                    'agendas.end_time', 
                    'agendas.location', 
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw('rooms.name AS room'),
                    DB::raw('suggestions.title AS suggestion')
                )
                ->paginate(15);
        if ($search != null) {
            $data = DB::table('suggestions')
                    ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                    ->join('departments', 'agendas.department_id', '=', 'departments.id')
                    ->join('categories', 'agendas.category_id', '=', 'categories.id')
                    ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                    ->join('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                    ->select(
                        'agendas.id', 
                        'agendas.title', 
                        'agendas.date', 
                        'agendas.start_time', 
                        'agendas.end_time', 
                        'agendas.location', 
                        'agendas.contents', 
                        'agendas.attachment', 
                        DB::raw('users.name AS person_in_charge'), 
                        DB::raw('departments.name AS department'),
                        DB::raw('categories.name AS category'),
                        DB::raw('rooms.name AS room'),
                        DB::raw('suggestions.title AS suggestion')
                    )
                    ->where('agendas.title', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.date', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.start_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.end_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.location', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.contents', 'LIKE', '%' . $search .'%')
                    ->orWhere('users.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('departments.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('categories.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('rooms.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.title', 'LIKE', '%' . $search .'%')
                    ->paginate(15);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Agenda',
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
     * @param  \App\Http\Requests\StoreAgendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if
        $validator = Validator::make($request->all(), [
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

        $data = Agenda::create([
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'room_id' => $request->room_id,
            'suggestion_id' => $request->suggestion_id,
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
                'message' => 'Agenda baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Agenda baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //add join
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda!',
            'data'    => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgendaRequest  $request
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }

        //if
        $validator = Validator::make($request->all(), [
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
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'room_id' => $request->room_id,
            'suggestion_id' => $request->suggestion_id,
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
                'message' => 'Data agenda gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil diubah!',
            'data'    => $data
        ], 200);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil dihapus!'
        ], 200);
    }
}
