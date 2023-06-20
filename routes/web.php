<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SuggestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'destroy']);
Route::get('/profil', [AuthController::class, 'getProfile']);
Route::post('/password', [AuthController::class, 'changePassword']);

Route::resource('/agenda', AgendaController::class)->only(['index', 'store']);
Route::resource('/pegawai', EmployeeController::class)->only(['index', 'store', 'update']);
Route::post('/password-reset/{id}', [EmployeeController::class, 'passwordReset']);
Route::resource('/posisi', PositionController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('/bidang', DepartmentController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('/kategori', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('/ruangan', RoomController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('/pengajuan', SuggestionController::class)->only(['index', 'create', 'store']);
Route::get('/ajuan-agenda', [SuggestionController::class, 'create']);
Route::resource('/grafik', ReportController::class)->only(['index']);
Route::post('/grafik', [ReportController::class, 'index']);
Route::resource('/notify', NotificationController::class)->only(['index', 'store']);
Route::post('/approve-pengajuan/{id}', [SuggestionController::class, 'approveAgenda']);
Route::post('/deny-pengajuan/{id}', [SuggestionController::class, 'denyAgenda']);
Route::get('/generate-agenda-text', [GenerateController::class, 'generateAgendaText']);
Route::get('/download-agenda-excel', [GenerateController::class, 'generateAgendaExcel']);