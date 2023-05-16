<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AgendaDisposition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; 

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', null);
        $order = $request->input('order', 'date');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 15);
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                    'agendas.start_time', 
                    'agendas.end_time', 
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                )
                ->orderBy($order, $sort)->paginate($page);
        if ($search != null) {
            $data = DB::table('agendas')
                    ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                    ->join('departments', 'agendas.department_id', '=', 'departments.id')
                    ->join('categories', 'agendas.category_id', '=', 'categories.id')
                    ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                    ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                    ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                    ->select(
                        'agendas.id', 
                        'agendas.title', 
                        'agendas.date', 
                        DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                        'agendas.start_time', 
                        'agendas.end_time', 
                        DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                        'agendas.contents', 
                        'agendas.attachment', 
                        DB::raw('users.name AS person_in_charge'), 
                        DB::raw('departments.name AS department'),
                        DB::raw('categories.name AS category'),
                        DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                    )
                    ->where('agendas.title', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.date', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.start_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.end_time', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.location', 'LIKE', '%' . $search .'%')
                    ->orWhere('agendas.contents', 'LIKE', '%' . $search .'%')
                    ->orWhere('users.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('departments.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('categories.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('rooms.name', 'LIKE', '%' . $search .'%')
                    ->orWhere('suggestions.title', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Agenda',
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
     * @param  \App\Http\Requests\StoreAgendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required',
            'category_id' => 'required',
            'room_id' => 'required',
            'person_in_charge' => 'required',
            'title' => 'required|string',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required_unless:room_id,1,2',
            'location' => 'required_if:room_id,1,2',
            'contents' => 'required|string',
            'attachment' => 'file|mimes:xls,xlsx,doc,docx,pdf,zip,jpg,jpeg,png|max:2048',
            'disposition_employee' => 'required_if:disposition_department,null|required_if:disposition_description,null|required_if:disposition_is_all,null',
            'disposition_department' => 'required_if:disposition_employee,null|required_if:disposition_description,null|required_if:disposition_is_all,null',
            'disposition_description' => 'required_if:disposition_employee,null|required_if:disposition_department,null|required_if:disposition_is_all,null',
            'disposition_is_all' => 'required_if:disposition_employee,null|required_if:disposition_department,null|required_if:disposition_description,null',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //if attachment != null ntar upload dulu sama rename terus save ke folder uploads
        $attachment = $request->file('attachment');
        $attachment_newname = '';
        if ($attachment != null) {
            $path = 'uploads/agendas_attachments/';
            $extension = $attachment->getClientOriginalExtension();
            $attachment_newname = Str::uuid().".".$extension;
            $attachment->move($path, $attachment_newname);
        }

        $data = Agenda::create([
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'room_id' => $request->room_id,
            'suggestion_id' => $request->suggestion_id,
            'person_in_charge' => $request->person_in_charge,
            'title' => $request->title,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'contents' => $request->contents,
            'attachment' => $attachment_newname,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda baru gagal ditambahkan!'
            ], 409);
        }

        $agenda = DB::table('agendas')->select('id')->latest('created_at')->first();
        $data = AgendaDisposition::create([
            'agenda_id' => $agenda->id,
            'user_id' => $request->disposition_employee,
            'department_id' => $request->disposition_department,
            'description' => $request->disposition_description,
            'is_all' => $request->disposition_is_all
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Disposisi agenda baru gagal ditambahkan!'
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Agenda baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                    'agendas.start_time', 
                    'agendas.end_time', 
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN  agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                )->where('agendas.id', $id)->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda!',
            'data'    => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgendaRequest  $request
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }

        //if
        $validator = Validator::make($request->all(), [
            'department_id' => 'required',
            'category_id' => 'required',
            'room_id' => 'required',
            'person_in_charge' => 'required',
            'title' => 'required|string',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required_unless:room_id,1,2',
            'location' => 'required_if:room_id,1,2',
            'contents' => 'required|string',
            'attachment' => 'file|mimes:xls,xlsx,doc,docx,pdf,zip,jpg,jpeg,png|max:2048',
            'disposition_employee' => 'required_if:disposition_department,null|required_if:disposition_description,null|required_if:disposition_is_all,null',
            'disposition_department' => 'required_if:disposition_employee,null|required_if:disposition_description,null|required_if:disposition_is_all,null',
            'disposition_description' => 'required_if:disposition_employee,null|required_if:disposition_department,null|required_if:disposition_is_all,null',
            'disposition_is_all' => 'required_if:disposition_employee,null|required_if:disposition_department,null|required_if:disposition_description,null',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attachment = $request->file('attachment');
        $path = 'uploads/agendas_attachments/';
        $attachment_newname = '';
        if ($attachment != null) {
            $extension = $attachment->getClientOriginalExtension();
            $attachment_newname = Str::uuid().".".$extension;
            $attachment->move($path, $attachment_newname);
        }
        
        if ($data->attachment != null) {
            File::delete($path . $data->attachment);
        }

        $data->update([
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'room_id' => $request->room_id,
            'suggestion_id' => $request->suggestion_id,
            'person_in_charge' => $request->person_in_charge,
            'title' => $request->title,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'contents' => $request->contents,
            'attachment' => $attachment_newname,
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda gagal diubah!'
            ], 409);
        }

        $data2 = AgendaDisposition::where('agenda_id', $id)->first();
        $data2->update([
            'user_id' => $request->disposition_employee,
            'department_id' => $request->disposition_department,
            'description' => $request->disposition_description,
            'is_all' => $request->disposition_is_all
        ]);
        if (!$data2) {
            return response()->json([
                'success' => false,
                'message' => 'Disposisi agenda gagal diubah!'
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil diubah!',
            'data'    => $data
        ], 200);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Agenda::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        if ($data->attachment != null) {
            $path = 'uploads/agendas_attachments/';
            File::delete($path . $data->attachment);
        }
        $data2 = AgendaDisposition::where('agenda_id', $id)->first();
        $data2->delete();
        $data->delete();
        if (!$data || !$data2) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil dihapus!'
        ], 200);
    }

    public function showYesterdayAgenda() {
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                    'agendas.start_time', 
                    'agendas.end_time', 
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                )
                ->whereRaw(DB::raw('DATE(agendas.date) = SUBDATE(CURDATE(),1)'))->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda!',
            'data'    => $data
        ], 200);
    }

    public function showTodayAgenda() {
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                    'agendas.start_time', 
                    'agendas.end_time', 
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                )
                ->whereRaw(DB::raw('DATE(agendas.date) = DATE(NOW())'))->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda!',
            'data'    => $data
        ], 200);
    }

    public function showTomorrowAgenda() {
        $data = DB::table('agendas')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('suggestions', 'agendas.suggestion_id', '=', 'suggestions.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    'agendas.id', 
                    'agendas.title', 
                    'agendas.date', 
                    DB::raw("DATE_FORMAT(agendas.created_at, \"%Y-%m-%d\") AS agenda_date"),
                    'agendas.start_time', 
                    'agendas.end_time', 
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN rooms.name ELSE agendas.location END) AS location"),
                    'agendas.contents', 
                    'agendas.attachment', 
                    DB::raw('users.name AS person_in_charge'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('categories.name AS category'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition")
                )
                ->whereRaw(DB::raw('DATE(agendas.date) = DATE(NOW()) + 1'))->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data agenda tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda!',
            'data'    => $data
        ], 200);
    }
}
