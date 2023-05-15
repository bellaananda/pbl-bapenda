<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class AgendaExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $month, $year;

    function __construct($month, $year) {
            $this->month = $month;
            $this->year = $year;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Waktu',
            'Nama Agenda',
            'Kategori',
            'Bidang',
            'Tempat',
            'Detail Tempat',
            'Penanggung Jawab',
            'Disposisi',
            'Isi Agenda'
        ];
    } 

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:K1')
                            ->getFont()
                            ->setBold(true);
            },
        ];
    }

    public function collection()
    {
        $month = $this->month;
        $year = $this->year;
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
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition"), 
                    'agendas.contents', 
                )
                ->whereRaw("YEAR(agendas.date) = " . $year . " AND MONTH(agendas.date) = " . $month)
                ->orderBy('agendas.date', 'ASC')->get();
        } else {
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
                    DB::raw("(CASE WHEN agenda_dispositions.user_id IS NOT NULL THEN users.name WHEN agenda_dispositions.department_id IS NOT NULL THEN departments.name WHEN agenda_dispositions.is_all = 1 THEN 'Seluruh Pegawai' ELSE agenda_dispositions.description END) AS disposition"), 
                    'agendas.contents', 
                )
                ->orderBy('agendas.date', 'ASC')->get();
        }
        return $data;
    }
}