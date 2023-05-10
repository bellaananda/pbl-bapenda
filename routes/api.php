<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DispositionController;
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
Route::resource('/positions', PositionController::class);
Route::resource('/departments', DepartmentController::class);
Route::resource('/categories', CategoryController::class);
Route::resource('/rooms', RoomController::class);
Route::resource('/employees', EmployeeController::class);
Route::resource('/suggestions', SuggestionController::class);
Route::post('/suggestions-approve/{id}', [SuggestionController::class, 'approveAgenda']);
Route::post('/suggestions-deny/{id}', [SuggestionController::class, 'denyAgenda']);
Route::resource('/agendas', AgendaController::class);
Route::get('/agendas-yesterday', [AgendaController::class, 'showYesterdayAgenda']);
Route::get('/agendas-today', [AgendaController::class, 'showTodayAgenda']);
Route::get('/agendas-tomorrow', [AgendaController::class, 'showTomorrowAgenda']);
Route::resource('/dispositions', DispositionController::class);
Route::resource('/generate', GenerateController::class);
Route::get('/download-suggestions-excel', [GenerateController::class, 'generateSuggestionsExcel'])->name('suggestions.export');