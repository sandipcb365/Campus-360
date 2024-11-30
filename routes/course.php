<?php
use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::prefix('/courses')->group(function () {
    Route::get('/artificial_intelligence', [CoursesController::class, 'AIPage'])->name('artificial_intelligence');
    Route::get('/algorithm', [CoursesController::class, 'algoPage'])->name('algorithm');
    Route::get('/c_programming', [CoursesController::class, 'CPage'])->name('c_programming');
    Route::get('/c_plus_plus', [CoursesController::class, 'C_Page'])->name('c_plus_plus');
    Route::get('/digital_electronics', [CoursesController::class, 'DEPage'])->name('digital_electronics');
    Route::get('/data_structure', [CoursesController::class, 'DSPage'])->name('data_structure');
    Route::get('/html', [CoursesController::class, 'HTMLPage'])->name('html');
    Route::get('/java', [CoursesController::class, 'JavaPage'])->name('java');
    Route::get('/javascript', [CoursesController::class, 'JSPage'])->name('javascript');
    Route::get('/microprocessor', [CoursesController::class, 'microPage'])->name('microprocessor');
    Route::get('/machine_learning', [CoursesController::class, 'mlPage'])->name('machine_learning');
    Route::get('/mysql', [CoursesController::class, 'MySqlPage'])->name('mysql');
    Route::get('/oop', [CoursesController::class, 'OOPPage'])->name('oop');
    Route::get('/php', [CoursesController::class, 'PHPPage'])->name('php');
    Route::get('/python', [CoursesController::class, 'PythonPage'])->name('python');
    Route::get('/react', [CoursesController::class, 'ReactPage'])->name('react');
    Route::get('/vlsi', [CoursesController::class, 'VLSIPage'])->name('vlsi');
    Route::get('/load_more', [MainController::class, 'Load_MorePage'])->name('load_more');

    Route::get('/{course}/{yt_link}/constructionsms', [MainController::class, 'ConstructionSmsPage'])
        ->name('constructionsms');
});
