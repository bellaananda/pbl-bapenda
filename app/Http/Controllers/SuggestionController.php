<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use App\Http\Resources\ApiFormat;
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
        return new ApiFormat(true, 'Data Pengajuan Agenda', $data);
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
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
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
            return new ApiFormat(true, 'Pengajuan agenda baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Pengajuan agenda baru berhasil ditambahkan!', $data);
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
            return new ApiFormat(false, 'Data pengajuan agenda tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data pengajuan agenda!', $data);
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
            return new ApiFormat(false, 'Data pengajuan agenda tidak ditemukan!', null);
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
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
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
            return new ApiFormat(true, 'Data pengajuan agenda gagal diubah!', $data);
        }
        return new ApiFormat(true, 'Data pengajuan agenda berhasil diubah!', $data);
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
            return new ApiFormat(false, 'Data pengajuan agenda tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data pengajuan agenda berhasil dihapus!', $data);
    }
}
