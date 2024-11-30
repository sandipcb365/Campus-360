<?php
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EducationInfoController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\WorkInfoController;
use Illuminate\Support\Facades\Route;

Route::get('/personal_info', [PersonalInfoController::class, 'index'])->name('cvindex');
Route::post('/store_personal', [PersonalInfoController::class, 'store_personal']);

Route::get('/education_info', [EducationInfoController::class, 'index']);
Route::post('/store_education', [EducationInfoController::class, 'store_education']);
Route::get('/education_summary', [EducationInfoController::class, 'education_summary']);
Route::get('/edit_education/{id}', [EducationInfoController::class, 'edit_education']);
Route::post('/update_education/{id}', [EducationInfoController::class, 'update_education']);

Route::get('/work_info', [WorkInfoController::class, 'index']);
Route::post('/store_work', [WorkInfoController::class, 'store_work']);
Route::get('/summary_work', [WorkInfoController::class, 'summary_work']);
Route::get('/edit_work/{id}', [WorkInfoController::class, 'edit_work']);
Route::post('/update_work/{id}', [WorkInfoController::class, 'update_work']);

Route::get('/certificate_info', [CertificateController::class, 'index']);
Route::post('/store_certificate', [CertificateController::class, 'store_certificate']);
Route::get('/summary_certificate', [CertificateController::class, 'summary_certificate']);
Route::get('/edit_certificate/{id}', [CertificateController::class, 'edit_certificate']);
Route::post('/update_certificate/{id}', [CertificateController::class, 'update_certificate']);

Route::get('/objective_info', [ObjectiveController::class, 'index']);
Route::post('/store_objective', [ObjectiveController::class, 'store_objective']);
Route::get('/summary_objective', [ObjectiveController::class, 'summary_objective']);
Route::get('/edit_objective/{id}', [ObjectiveController::class, 'edit_objective']);
Route::post('/update_objective/{id}', [ObjectiveController::class, 'update_objective']);

Route::get('pdf_display', [PdfController::class, 'index']);
Route::get('pdf_download', [PdfController::class, 'download']);
