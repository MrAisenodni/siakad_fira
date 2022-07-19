<?php

use App\Http\Controllers\{
    PagesController,
    ProviderController,
};
use App\Http\Controllers\Studies\{
    ArticleController,
    ClassController as StdClassController,
    FinalExamController,
    LessonController as StdLessonController,
    MidtermController,
    ParentController,
    PaymentController as StdPaymentController,
    PresentController,
    PrintController,
    ProfileController,
    ReportScoreController,
    ScheduleController,
    StudentController,
    TeacherController,
};
use App\Http\Controllers\Masters\{
    BloodTypeController,
    CategoryController,
    ClassController,
    ExtracurricularController,
    FamilyStatusController,
    GradeController,
    LanguageController,
    LoginController,
    LessonController,
    OccupationController,
    PaymentController,
    ReasonController,
    ReligionController,
    StudyYearController,
    TagController,
};
use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Auth;
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

Route::get('/login', [PagesController::class, 'form_login']);
Route::get('/logout', [PagesController::class, 'logout']);
Route::post('/login', [PagesController::class, 'login']);

Route::middleware('authcheck')->group(function() {
    Route::get('/', [PagesController::class, 'dashboard']);
    
    // Route Master
    Route::resource('/master/agama', ReligionController::class);
    Route::resource('/master/alasan', ReasonController::class);
    Route::resource('/master/bahasa', LanguageController::class);
    Route::resource('/master/ekstrakurikuler', ExtracurricularController::class);
    Route::resource('/master/golongan-darah', BloodTypeController::class);
    Route::resource('/master/kelas', ClassController::class);
    Route::resource('/master/kategori', CategoryController::class);
    Route::resource('/master/login', LoginController::class);
    Route::resource('/master/mata-pelajaran', LessonController::class);
    Route::resource('/master/nilai', GradeController::class);
    Route::resource('/master/pekerjaan', OccupationController::class);
    Route::resource('/master/spp', PaymentController::class);
    Route::resource('/master/status-keluarga', FamilyStatusController::class);
    Route::resource('/master/tag', TagController::class);
    Route::resource('/master/tahun-pelajaran', StudyYearController::class);
    
    // Route Studi
    Route::resource('/studi/pengumuman', ArticleController::class);
    Route::resource('/studi/guru', TeacherController::class);
    Route::resource('/studi/jadwal-pembelajaran', ScheduleController::class);
    Route::resource('/studi/jadwal-uts', MidtermController::class);
    Route::post('/studi/jadwal-uts/student', [MidtermController::class, 'store_student']);
    Route::delete('/studi/jadwal-uts/student/{id}', [MidtermController::class, 'destroy_student']);
    Route::resource('/studi/jadwal-uas', FinalExamController::class);
    Route::post('/studi/jadwal-uas/student', [MidtermController::class, 'store_student']);
    Route::delete('/studi/jadwal-uas/student/{id}', [MidtermController::class, 'destroy_student']);
    Route::resource('/studi/kelas', StdClassController::class);
    Route::resource('/studi/mata-pelajaran', StdLessonController::class);
    Route::resource('/studi/orang-tua', ParentController::class);
    Route::resource('/provider', ProviderController::class);
    Route::get('/studi/presensi/{id}/cari', [PresentController::class, 'search']);
    Route::resource('/studi/presensi', PresentController::class);
    Route::resource('/studi/profil', ProfileController::class);
    Route::resource('/studi/siswa', StudentController::class);
    Route::get('/studi/spp/create-tagihan', [StdPaymentController::class, 'create_payment']);
    Route::post('/studi/spp/create-tagihan', [StdPaymentController::class, 'store_payment']);
    Route::resource('/studi/spp', StdPaymentController::class);
    Route::post('/what', [StdPaymentController::class, 'test']);

    // This part for Nilai Siswa
    Route::resource('/studi/nilai-siswa', ReportScoreController::class);
    Route::get('/studi/nilai-siswa/{id}/{ids}/edit', [ReportScoreController::class, 'edit']);
    Route::put('/studi/nilai-siswa/{id}/{ids}', [ReportScoreController::class, 'update']);
    Route::get('/studi/nilai-siswa/{id}/{ids}', [ReportScoreController::class, 'generate']);
    Route::get('/studi/nilai-siswa/{id}/create', [ReportScoreController::class, 'create']);
    
    // Print Routes (PDF)
    Route::get('/cetak/spp', [PrintController::class, 'print_payment']);
    Route::get('/cetak/guru', [PrintController::class, 'print_all_teacher']);
    Route::get('/cetak/siswa', [PrintController::class, 'print_all_student']);
    Route::get('/cetak/presensi/{id}', [PrintController::class, 'print_present']);
    Route::get('/studi/kelas/{id}/cetak', [PrintController::class, 'print_class']);
    Route::get('/studi/siswa/{id}/cetak', [PrintController::class, 'print_student']);
    
    // Print Routes (Word)
    Route::get('/studi/siswa/{id}/word', [PrintController::class, 'word_student']);
});

Route::get('/studi/nilai-siswa/{id}/{ids}/cetak', [PrintController::class, 'print_excel_score']);
Route::get('/download', [ArticleController::class, 'download']);