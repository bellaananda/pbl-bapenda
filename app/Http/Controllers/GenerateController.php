<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\AgendaExport;
use Maatwebsite\Excel\Facades\Excel;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = $request->input('month', 4);
        $year = $request->input('year', 2023);
        if ($month != null && $year != null) {
            $data = DB::table('agendas')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    DB::raw('ROW_NUMBER() OVER (ORDER BY `date` ASC) AS No'), 
                    DB::raw("CONCAT(DAY(date), ' ', CASE MONTH(date) WHEN 1 THEN 'Januari' WHEN 2 THEN 'Februari' WHEN 3 THEN 'Maret' WHEN 4 THEN 'April' WHEN 5 THEN 'Mei' WHEN 6 THEN 'Juni' WHEN 7 THEN 'Juli' WHEN 8 THEN 'Agustus' WHEN 9 THEN 'September' WHEN 10 THEN 'Oktober' WHEN 11 THEN 'November' WHEN 12 THEN 'Desember' END, ' ', YEAR(date)) AS Date"),
                    DB::raw("(CASE WHEN ISNULL(agendas.end_time) THEN TIME_FORMAT(agendas.start_time, \"%H:%i\") ELSE CONCAT(TIME_FORMAT(agendas.start_time, \"%H:%i\"), ' - ', TIME_FORMAT(agendas.start_time, \"%H:%i\")) END) AS Time"),
                    'agendas.title',
                    DB::raw('categories.name AS category'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('rooms.name AS room'),
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN '-' ELSE agendas.location END) AS location"),
                    DB::raw('users.name AS person_in_charge'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all IS NOT NULL THEN agenda_dispositions.is_all ELSE agenda_dispositions.description END) AS disposition"), 
                    'agendas.contents', 
                )
                ->whereRaw("YEAR(agendas.date) = " . $year . " AND MONTH(agendas.date) = " . $month)
                ->orderBy('agendas.date', 'ASC')->toSql();
            return $data;
        }
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

    public function generateAgendaText(Request $request) {
        //set header
        $header = "*Agenda BAPENDA Surakarta*";

        //set date
        $today = today()->format("Y-m-d");;
        $dateselected = $request->input('date', $today);
        $datetime = DateTime::createFromFormat("Y-m-d", $dateselected, new DateTimeZone('Asia/Jakarta'));

        //generate date in indonesian
        $day = $datetime->format("N");
        switch ($day) {
            case 1:
                $day = "Senin";
                break;
            case 2:
                $day = "Selasa";
                break;
            case 3:
                $day = "Rabu";
                break;
            case 4:
                $day = "Kamis";
                break;
            case 5:
                $day = "Jumat";
                break;
            case 6:
                $day = "Sabtu";
                break;
            case 7:
                $day = "Minggu";
                break;
            default:
                $day = "Senin";
                break;
        }
        $month = $datetime->format("n");
        switch ($month) {
            case 1:
                $month = "Januari";
                break;
            case 2:
                $month = "Februari";
                break;
            case 3:
                $month = "Maret";
                break;
            case 4:
                $month = "April";
                break;
            case 5:
                $month = "Mei";
                break;
            case 6:
                $month = "Juni";
                break;
            case 7:
                $month = "Juli";
                break;
            case 8:
                $month = "Agustus";
                break;
            case 9:
                $month = "September";
                break;
            case 10:
                $month = "Oktober";
                break;
            case 11:
                $month = "November";
                break;
            case 12:
                $month = "Desember";
                break;
            default:
                $month = "Januari";
                break;
        }
        $date = '_' . $day . ', ' . $datetime->format("j") . ' ' . $month . ' ' . $datetime->format("Y") . '_';

        //foreach or for loop to format record to text
        $data = DB::table('agendas')
                ->join('categories', 'agendas.category_id', '=', 'categories.id')
                ->join('departments', 'agendas.department_id', '=', 'departments.id')
                ->join('users', 'agendas.person_in_charge', '=', 'users.id')
                ->join('rooms', 'agendas.room_id', '=', 'rooms.id')
                ->leftJoin('agenda_dispositions', 'agendas.id', '=', 'agenda_dispositions.agenda_id')
                ->select(
                    DB::raw('ROW_NUMBER() OVER (ORDER BY `date` ASC) AS no'), 
                    DB::raw("(CASE WHEN ISNULL(agendas.end_time) THEN TIME_FORMAT(agendas.start_time, \"%H:%i\") ELSE CONCAT(TIME_FORMAT(agendas.start_time, \"%H:%i\"), ' - ', TIME_FORMAT(agendas.start_time, \"%H:%i\")) END) AS time"),
                    'agendas.title',
                    DB::raw('categories.name AS category'), 
                    DB::raw('departments.name AS department'),
                    DB::raw('rooms.name AS room'),
                    DB::raw("(CASE WHEN ISNULL(agendas.location) THEN '-' ELSE agendas.location END) AS location"),
                    DB::raw('users.name AS person_in_charge'),
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh BAPENDA' ELSE agenda_dispositions.description END) AS disposition"), 
                    'agendas.contents', 
                )
                ->whereRaw("agendas.date = '". date_format($datetime, "Y-m-d") . "'")
                ->orderBy('start_time', 'asc')
                ->get();
        $text = $header . "\n" . $date . "\n";
        foreach ($data as $val) {
            $subheader = "*#" . $val->no . ' - ' . $val->title . " (" . $val->time . ")*". "\n";
            $category = "Kategori: " . $val->category . "\n";
            $department = "Bidang: " . $val->department . "\n";
            $pic = "Penanggung Jawab: " . $val->person_in_charge . "\n";
            $location = "Tempat: " . $val->room;
            if ($val->location != '' && $val->location != null) {
                $location .= " (" . $val->location . ")";
            }
            $location .= "\n";
            $disposition = "Disposisi: " . $val->disposition . "\n";
            $contents = "Isi Agenda: " . $val->contents . "\n";
            $text .= $subheader . $category . $department . $pic . $location . $disposition . $contents;
        }
        return $text;
    }

    public function generateAgendaExcel(Request $request) {
        $month = $request->input('month', null);
        $year = $request->input('year', null);
        if ($month != null && $year != null) {
            //file name by selected month - year
            switch ($month) {
                case 1:
                    $bulan = 'Januari';
                    break;
                case 2:
                    $bulan = 'Februari';
                    break;
                case 3:
                    $bulan = 'Maret';
                    break;
                case 4:
                    $bulan = 'April';
                    break;
                case 5:
                    $bulan = 'Mei';
                    break;
                case 6:
                    $bulan = 'Juni';
                    break;
                case 7:
                    $bulan = 'Juli';
                    break;
                case 8:
                    $bulan = 'Agustus';
                    break;
                case 9:
                    $bulan = 'September';
                    break;
                case 10:
                    $bulan = 'Oktober';
                    break;
                case 11:
                    $bulan = 'November';
                    break;
                case 12:
                    $bulan = 'Desember';
                    break;
                default:
                    $bulan = 'Januari';
            }
            $filename = 'Agenda-Bapenda' . '-' . $bulan . '-' . $year . '.xlsx';
            return Excel::download(new AgendaExport($month, $year), $filename);
        }
        return Excel::download(new AgendaExport($month, $year), 'Agenda-Bapenda.xlsx');
    }
}
