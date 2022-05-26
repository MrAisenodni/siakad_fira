<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Masters\{
    FamilyStatusController,
    LessonController,
    OccupationController,
    ReasonController,
    ReligionController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'dashboard']);

// Route Master
Route::resource('/master/agama', ReligionController::class);
Route::resource('/master/status-keluarga', FamilyStatusController::class);
Route::resource('/master/pekerjaan', OccupationController::class);
Route::resource('/master/alasan', ReasonController::class);
Route::resource('/master/mata-pelajaran', LessonController::class);