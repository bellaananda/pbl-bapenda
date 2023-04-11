<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Resources\ApiFormat;
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
    public function index()
    {
        $data = Department::paginate(15);
        return new ApiFormat(true, 'Daftar Bidang', $data);
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
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data = Department::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Bidang baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Bidang baru berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $data = Department::find($department);
        if (!$data) {
            return new ApiFormat(false, 'Data bidang tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data bidang!', $data);
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
            return new ApiFormat(false, 'Data bidang tidak ditemukan!', null);
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

        return new ApiFormat(true, 'Data bidang berhasil diubah!', $data);
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
            return new ApiFormat(false, 'Data bidang tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data bidang berhasil dihapus!', $data);
    }
}
