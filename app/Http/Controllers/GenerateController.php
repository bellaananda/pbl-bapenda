<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateAgendaText(Request $request) {
        //generate text (operator, admin)
        $date = $request->input('copydate', today()->format("Y-m-d"));
        $token = Session::get('access_token');
        if ($token == null) {
            return null;
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/generate-agenda-text", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'dateselected' => $date
            ],
            'verify' => false
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);
        $data =  $result['data'];
        return $data;
    }

    public function generateAgendaExcel(Request $request) {
        //generate text (operator, admin)
        $selected = $request->input('exceldate', date('Y-m'));
        $array = explode("-", $selected);
        $month = $array[1];
        $year = $array[0];
        $token = Session::get('access_token');
        if ($token == null) {
            return null;
        }
        $client = new Client;
        $base_uri = "https://api.klikagenda.com/api";
        $response = $client->request('GET', "{$base_uri}/download-agenda-excel", [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'month' => $month,
                'year' => $year
            ],
            'verify' => false
        ]);
        $fileContent = $response->getBody()->getContents();
        $filename = 'Agenda-Bapenda.xlsx';
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
        }

        // Set the appropriate content type and disposition headers
        $headers = [
            'Content-Type' => $response->getHeader('Content-Type')[0],
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Create the response with file content and headers
        $response = new Response($fileContent, 200, $headers);

        // Return the response to trigger the file download
        return $response;
    }
}
