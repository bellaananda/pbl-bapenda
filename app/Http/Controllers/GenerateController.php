<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Exports\SuggestionExport;
use Maatwebsite\Excel\Facades\Excel;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateSuggestionsPDF() {
        //bisanya digenerate pake blade, nama file pakai date sesuai hari agenda
        $data = DB::table('suggestions')
            ->join('users', 'suggestions.user_id', '=', 'users.id')
            ->join('departments', 'suggestions.department_id', '=', 'departments.id')
            ->join('categories', 'suggestions.category_id', '=', 'categories.id')
            ->join('rooms', 'suggestions.room_id', '=', 'rooms.id')
            ->select(
                'suggestions.id', 
                'suggestions.title', 
                'suggestions.date', 
                'suggestions.start_time', 
                'suggestions.end_time', 
                DB::raw("(CASE WHEN ISNULL(location) THEN rooms.name ELSE suggestions.location END) AS location"),
                'suggestions.contents', 
                'suggestions.attachment', 
                'suggestions.status', 
                DB::raw('users.name AS user'), 
                DB::raw('departments.name AS department'),
                DB::raw('categories.name AS category'),
                DB::raw('users.name AS person_in_charge')
            )->get()->toArray();
        view()->share('suggestions', $data);
        $pdf = PDF::loadView('suggestions', $data);
        return $pdf->download('pdf_file.pdf');
    }

    public function generateSuggestionsExcel() {
        return Excel::download(new SuggestionExport, 'suggestions.xlsx');
    }
}
