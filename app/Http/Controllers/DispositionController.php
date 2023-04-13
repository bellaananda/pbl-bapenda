<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $page = $request->page == null ? 15 : $request->page;
        $data = DB::table('dispositions')
                ->paginate(15);
        return response()->json([
            'success' => true,
            'message' => 'Daftar Disposisi Agenda',
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
     * @param  \App\Http\Requests\StoreDispositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agenda_id' => 'required',
            'user_id' => '',
            'department_id' => '',
            'description' => '',
            'is_all' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Disposition::create([
            'agenda_id' => $request->agenda_id,
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'is_all' => $request->is_all,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Disposisi agenda baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Disposisi agenda baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Disposition::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data disposisi agenda tidak ditemukan!', null);
            return response()->json([
                'success' => false,
                'message' => 'Data disposisi agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data disposisi agenda!',
            'data'    => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function edit(Disposition $disposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDispositionRequest  $request
     * @param  \App\Models\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Disposition::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data disposisi agenda tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'agenda_id' => 'required',
            'user_id' => '',
            'department_id' => '',
            'description' => '',
            'is_all' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'agenda_id' => $request->agenda_id,
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'is_all' => $request->is_all,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data disposisi agenda gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data disposisi agenda berhasil diubah!',
            'data'    => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Disposition::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data disposisi agenda tidak ditemukan!', null);
            return response()->json([
                'success' => false,
                'message' => 'Data disposisi agenda tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data disposisi agenda gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data disposisi agenda berhasil dihapus!'
        ], 200);
    }
}
