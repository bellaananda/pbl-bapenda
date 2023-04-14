<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\EmployeeController;
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
Route::resource('/agendas', AgendaController::class);
Route::resource('/dispositions', DispositionController::class);