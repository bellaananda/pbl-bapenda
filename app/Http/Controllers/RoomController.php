<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 15);
        $data = Room::paginate($page);
        if ($search != null) {
            $data = DB::table('rooms')
                    ->where('name', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Ruangan',
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
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Room::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Ruangan baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Room::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data ruangan!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil diubah!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data ruangan gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil dihapus!'
        ], 200);
    }
}
