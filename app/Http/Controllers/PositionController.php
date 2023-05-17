<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 15);
        $data = Position::paginate($page);
        if ($search != null) {
            $data = DB::table('positions')
                    ->where('name', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Jabatan',
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
     * @param  \App\Http\Requests\StorePositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:positions',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Position::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Jabatan baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Jabatan baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Position::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data jabatan!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:positions',
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
                'message' => 'Data jabatan gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data jabatan berhasil diubah!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data jabatan berhasil dihapus!'
        ], 200);
    }

    public function trash(Request $request)
    {
        $page = $request->input('page', 15);
        $data = Position::onlyTrashed()->paginate($page);
        return response()->json([
            'success' => true,
            'message' => 'Daftar Jabatan (Dihapus)',
            'data'    => $data  
        ], 200);
    }

    public function restore($id)
    {
        $data = Position::withTrashed()->find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan di sampah!'
            ], 404);
        }
        if($data->trashed()){
            $data->restore();
            return response()->json([
                'success' => true,
                'message' => 'Data jabatan berhasil dipulihkan!',
                'data'    => $data  
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan di sampah!',
            ], 404);
        }
    }

    public function deletePermanent($id)
    {
        $data = Position::withTrashed()->find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan di sampah!'
            ], 404);
        }
        if(!$data->trashed())
        {
            return response()->json([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan di sampah!',
            ], 404);
        } else {
            $data->forceDelete();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jabatan gagal dihapus permanen!'
                ], 409);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data jabatan berhasil dihapus permanen!'
            ], 200);
        }
    }
}
