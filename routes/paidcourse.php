<?php

use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Job\ModuleController;
use App\Http\Controllers\Job\PaidCourseController;
use Illuminate\Support\Facades\Route;

/// Courses
Route::get('/job_preparation', [JobController::class, 'index'])->name('job_preparation');

Route::get('/job_preparation/{encryptedId}', [PaidCourseController::class, 'showPaidCourse'])->name('job_preparation.show');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::post('/job_preparation', [PaidCourseController::class, 'storePaidCourse'])->name('job_preparation.store');
    Route::put('/job_preparation/{encryptedId}', [PaidCourseController::class, 'updatepaidCourse'])->name('job_preparation.update');

    Route::post('/job_preparation/storeModule/{encryptedId}', [ModuleController::class, 'storeModule'])->name('job_preparation.storeModule');
    Route::put('/job_preparation/update_module/{encryptedId}', [ModuleController::class, 'updateModule'])->name('job_preparation.update_module');

    Route::put('/job_preparation/update_module_video/{encryptedId}', [ModuleController::class, 'updateModuleVideo'])->name('job_preparation.update_module_video');

    Route::put('/job_preparation/update_module_resource/{encryptedId}', [ModuleController::class, 'updateModuleResource'])->name('job_preparation.update_module_resource');

    Route::post('/update_is_locked/{moduleId}/{encryptedId}', [ModuleController::class, 'lockModule'])->name('update_is_locked');

    Route::delete('/delete_module/{moduleId}/{encryptedId}', [ModuleController::class, 'deleteModule'])->name('delete_module');

    Route::post('/upload-covered-topics/{module_id}', [ModuleController::class, 'storeTitle'])->name('uploadModuleTitle');

    Route::post('/update-module-topics/{module_id}', [ModuleController::class, 'updateModuleTopics'])->name('updateModuleTopics');

    Route::post('/upload-assignment-topics/{module_id}', [ModuleController::class, 'storeAssignmentTopics'])->name('uploadAssignmentTopics');

    Route::post('/upload-module-video/{module_id}', [ModuleController::class, 'storeVideo'])->name('uploadModuleVideo');

    Route::post('/upload-module-resource/{module_id}', [ModuleController::class, 'storeResources'])->name('uploadResources');

    Route::post('/update-assignment-topics/{module_id}', [ModuleController::class, 'updateAssignmentTopics'])->name('updateAssignmentTopics');

    Route::delete('/delete_module_video/{moduleId}/{encryptedId}/{videoId}', [ModuleController::class, 'deleteModuleVideo'])->name('delete_module_video');

    Route::delete('/delete_module_resource/{moduleId}/{encryptedId}/{resourceId}', [ModuleController::class, 'deleteModuleResource'])->name('delete_module_resource');
});

Route::middleware(['auth', 'verified', 'admin_techer'])->group(function () {
    Route::post('/assignMarks/{assignment_id}', [ModuleController::class, 'assignMarks'])->name('assignMarks');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/job_preparation/{courseName}/{moduleNumber}/{encryptedModuleId}', [ModuleController::class, 'showModule'])->name('showModule');

    Route::get('/job_preparation/{courseName}/{moduleNumber}/pre-recorded-videos/{encryptedModuleId}', [ModuleController::class, 'showModuleVideo'])->name('showModuleVideo');

    Route::get('/job_preparation/{courseName}/{moduleNumber}/pre-resources/{encryptedModuleId}', [ModuleController::class, 'showModuleResource'])->name('showModuleResource');

    Route::get('/job_preparation/{courseName}/{moduleNumber}/pre-recorded-videos/{videoNumber}/{videoId}/{encryptedModuleId}', [ModuleController::class, 'viewModuleVideo'])->name('viewModuleVideo');

    Route::post('/upload-file/{module_id}', [ModuleController::class, 'assignment'])->name('uploadFile');
});
