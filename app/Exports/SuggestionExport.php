<?php

namespace App\Exports;

use App\Models\Suggestion;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class SuggestionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'No',
            'Judul',
            'Tanggal',
            'Waktu Mulai',
            'Waktu Selesai',
            'Tempat',
            'Detail Tempat',
        ];
    } 

    public function collection()
    {
        $data = DB::table('suggestions')
                ->join('users', 'suggestions.user_id', '=', 'users.id')
                ->join('departments', 'suggestions.department_id', '=', 'departments.id')
                ->join('categories', 'suggestions.category_id', '=', 'categories.id')
                ->join('rooms', 'suggestions.room_id', '=', 'rooms.id')
                ->select(
                    DB::raw('ROW_NUMBER() OVER (ORDER BY `date` DESC) AS No'), 
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
                )
                ->get();
        return $data;
        // return Suggestion::all();
    }
}
