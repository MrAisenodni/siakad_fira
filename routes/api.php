<?php

use App\Http\Controllers\Api\{
    LessonController,
    PaymentController,
    StudentController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('/siswa', StudentController::class);
Route::resource('/spp', PaymentController::class);
// Route::resource('/mata-pelajaran', LessonController::class);
Route::get('/mata-pelajaran/{id}/{cid}/{sid}', [LessonController::class, 'show']);