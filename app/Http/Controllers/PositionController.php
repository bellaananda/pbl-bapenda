<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Position::paginate(15);
        return new ApiFormat(true, 'Daftar Jabatan', $data);
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
     * @param  \App\Http\Requests\StorePositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data = Position::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Jabatan baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Jabatan baru berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        $data = Position::find($position);
        if (!$data) {
            return new ApiFormat(false, 'Data jabatan tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data jabatan!', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePositionRequest  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $data = Position::find($position->id);
        if (!$data) {
            return new ApiFormat(false, 'Data jabatan tidak ditemukan!', null);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data->update([
            'name' => $request->name
        ]);

        return new ApiFormat(true, 'Data jabatan berhasil diubah!', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $data = Position::find($position->id);
        if (!$data) {
            return new ApiFormat(false, 'Data jabatan tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data jabatan berhasil dihapus!', $data);
    }
}
