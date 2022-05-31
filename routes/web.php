<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Studies\{
    ParentController,
    StudentController,
    TeacherController,
};
use App\Http\Controllers\Masters\{
    BloodTypeController,
    ClassController,
    ExtracurricularController,
    FamilyStatusController,
    LanguageController,
    LessonController,
    OccupationController,
    ReasonController,
    ReligionController,
    StudyYearController,
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
Route::resource('/master/alasan', ReasonController::class);
Route::resource('/master/bahasa', LanguageController::class);
Route::resource('/master/ekstrakurikuler', ExtracurricularController::class);
Route::resource('/master/golongan-darah', BloodTypeController::class);
Route::resource('/master/kelas', ClassController::class);
Route::resource('/master/mata-pelajaran', LessonController::class);
Route::resource('/master/pekerjaan', OccupationController::class);
Route::resource('/master/status-keluarga', FamilyStatusController::class);
Route::resource('/master/tahun-pelajaran', StudyYearController::class);

// Route Studi
Route::resource('/studi/guru', TeacherController::class);
Route::resource('/studi/orang-tua', ParentController::class);
Route::resource('/studi/siswa', StudentController::class);