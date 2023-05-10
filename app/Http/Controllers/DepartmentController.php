<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        $data = Department::paginate($page);
        if ($search != null) {
            $data = DB::table('departments')
                    ->where('name', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Bidang',
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
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:departments',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Department::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Bidang baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Bidang baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Department::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data bidang tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data bidang!',
            'data'    => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $data = Department::find($department->id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data bidang tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:departments',
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
                'message' => 'Data bidang gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data bidang berhasil diubah!',
            'data'    => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $data = Department::find($department->id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data bidang tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data bidang gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data bidang berhasil dihapus!'
        ], 200);
    }
}
