<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //field nya
        $data = DB::table('users')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->join('departments', 'users.department_id', '=', 'departments.id')
                ->select(
                    'users.id', 
                    'users.nip', 
                    'users.name', 
                    'users.email', 
                    'users.phone_number', 
                    'users.address', 
                    'users.role', 
                    'users.status', 
                    DB::raw('positions.name AS position'), 
                    DB::raw('departments.name AS department')
                )
                ->paginate(15);
        return new ApiFormat(true, 'Data Pegawai', $data);
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
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position_id' => 'required',
            'department_id' => 'required',
            'nip' => 'required|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100|unique:users',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data = User::create([
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('bapenda123'),
            'phone_number' => $request->phone_number,
            'address' => $request->address
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Pegawai baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Pegawai baru berhasil ditambahkan!', $data);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data pegawai tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data pegawai!', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data pegawai tidak ditemukan!', null);
        }

        $validator = Validator::make($request->all(), [
            'position_id' => 'required',
            'department_id' => 'required',
            'nip' => 'required|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data->update([
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Data pegawai gagal diubah!', $data);
        }
        return new ApiFormat(true, 'Data pegawai berhasil diubah!', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if (!$data) {
            return new ApiFormat(false, 'Data pegawai tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data pegawai berhasil dihapus!', $data);
    }
}
