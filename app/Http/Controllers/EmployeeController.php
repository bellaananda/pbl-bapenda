<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\DB;
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
        $data = DB::table('users')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->join('departments', 'users.department_id', '=', 'departments.id')
                ->select('users.*', DB::raw('positions.name AS position', 'departments.name AS department'))
                ->get();
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
        // $data = new User();
        // $data->position_id = $request->position_id;
        // $data->department_id = $request->department_id;
        // $data->nip = $request->nip;
        // $data->name = $request->name;
        // $data->email = $request->email;
        // $data->save();
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
            'name' => $request->name
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Jabatan baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Jabatan baru berhasil ditambahkan!', $data);
        
        return new ApiFormat(true, 'Data pegawai berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
