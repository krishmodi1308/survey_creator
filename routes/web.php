<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SurveyController::class, 'index'])->name('surveys.index');
Route::get('surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
Route::post('surveys', [SurveyController::class, 'store'])->name('surveys.store');
Route::get('surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
Route::get('surveys/{survey}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
Route::put('surveys/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
Route::delete('surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
Route::post('surveys/{survey}/submit', [SurveyController::class, 'submit'])->name('surveys.submit');
Route::get('surveys/{survey}/participate', [SurveyController::class, 'participate'])->name('surveys.participate');
Route::get('/surveys/{survey}/report', [SurveyController::class, 'report'])->name('surveys.report');
