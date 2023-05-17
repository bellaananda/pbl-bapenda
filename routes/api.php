<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SuggestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/positions', PositionController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::get('/positions-trash', [PositionController::class, 'trash'])->name('trash');
Route::post('/positions-trash/{id}/restore', [PositionController::class, 'restore'])->name('restore');
Route::delete('/positions-trash/{id}/delete', [PositionController::class,'deletePermanent'])->name('deletePermanent');
Route::resource('/departments', DepartmentController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::get('/departments-trash', [DepartmentController::class, 'trash'])->name('trash');
Route::post('/departments-trash/{id}/restore', [DepartmentController::class, 'restore'])->name('restore');
Route::delete('/departments-trash/{id}/delete', [DepartmentController::class,'deletePermanent'])->name('deletePermanent');
Route::resource('/categories', CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::get('/categories-trash', [CategoryController::class, 'trash'])->name('trash');
Route::post('/categories-trash/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
Route::delete('/categories-trash/{id}/delete', [CategoryController::class,'deletePermanent'])->name('deletePermanent');
Route::resource('/rooms', RoomController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::get('/rooms-trash', [RoomController::class, 'trash'])->name('trash');
Route::post('/rooms-trash/{id}/restore', [RoomController::class, 'restore'])->name('restore');
Route::delete('/rooms-trash/{id}/delete', [RoomController::class,'deletePermanent'])->name('deletePermanent');
Route::resource('/employees', EmployeeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::resource('/suggestions', SuggestionController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::post('/suggestions-approve/{id}', [SuggestionController::class, 'approveAgenda']);
Route::post('/suggestions-deny/{id}', [SuggestionController::class, 'denyAgenda']);
Route::get('/suggestions-user/{id}', [SuggestionController::class, 'indexUser']);
Route::resource('/agendas', AgendaController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::get('/agendas-yesterday', [AgendaController::class, 'showYesterdayAgenda']);
Route::get('/agendas-today', [AgendaController::class, 'showTodayAgenda']);
Route::get('/agendas-tomorrow', [AgendaController::class, 'showTomorrowAgenda']);
// Route::resource('/generate', GenerateController::class);
Route::get('/download-agenda-excel', [GenerateController::class, 'generateAgendaExcel'])->name('agendas.export');
Route::get('/generate-agenda-text', [GenerateController::class, 'generateAgendaText']);