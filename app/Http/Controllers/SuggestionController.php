<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
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
    public function index()
    {
        $data = DB::table('suggestions')
                ->paginate(15);
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
        $data = Suggestion::find($id);
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
}
