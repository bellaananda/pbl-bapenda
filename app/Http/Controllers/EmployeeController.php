<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function index(Request $request)
    {
        //field nya
        $search = $request->search;
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
        if ($search != null) {
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
                ->where('users.nip', 'LIKE', '%' . $search .'%')
                ->orWhere('users.name', 'LIKE', '%' . $search .'%')
                ->orWhere('users.email', 'LIKE', '%' . $search .'%')
                ->orWhere('users.phone_number', 'LIKE', '%' . $search .'%')
                ->orWhere('users.address', 'LIKE', '%' . $search .'%')
                ->orWhere('users.role', 'LIKE', '%' . $search .'%')
                ->orWhere('users.status', 'LIKE', '%' . $search .'%')
                ->orWhere('positions.name', 'LIKE', '%' . $search .'%')
                ->orWhere('departments.name', 'LIKE', '%' . $search .'%')
                ->paginate(15);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Pegawai',
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
            return response()->json($validator->errors(), 400);
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
            return response()->json([
                'success' => false,
                'message' => 'Pegawai baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pegawai baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id)
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
                ->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data pegawai!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan!'
            ], 404);
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
            return response()->json($validator->errors(), 400);
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
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil diubah!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil dihapus!'
        ], 200);
    }
}
