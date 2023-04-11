<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Room::paginate(15);
        return new ApiFormat(true, 'Daftar Ruangan', $data);
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
     * @param  \App\Http\Requests\StoreRoomRequest  $request
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

        $data = Room::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Ruangan baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Ruangan baru berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $data = Room::find($room);
        if (!$data) {
            return new ApiFormat(false, 'Data ruangan tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data ruangan!', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $data = Room::find($room->id);
        if (!$data) {
            return new ApiFormat(false, 'Data ruangan tidak ditemukan!', null);
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

        return new ApiFormat(true, 'Data ruangan berhasil diubah!', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $data = Room::find($room->id);
        if (!$data) {
            return new ApiFormat(false, 'Data ruangan tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data ruangan berhasil dihapus!', $data);
    }
}
