<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Http\Resources\ApiFormat;
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
    public function index()
    {
        $data = DB::table('agendas')
                ->get();
        return new ApiFormat(true, 'Data Agenda', $data);
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
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
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
            return new ApiFormat(true, 'Agenda baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Agenda baru berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data agenda tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data agenda!', $data);
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
            return new ApiFormat(false, 'Data agenda tidak ditemukan!', null);
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
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
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
            return new ApiFormat(true, 'Data agenda gagal diubah!', $data);
        }
        return new ApiFormat(true, 'Data agenda berhasil diubah!', $data);
    }

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
            return new ApiFormat(false, 'Data agenda tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data agenda berhasil dihapus!', $data);
    }
}
