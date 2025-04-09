<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
// Route::get('/', function () {
// //    return view('welcome');
//    return Inertia::render('home');
// });

use Inertia\Inertia;

Route::get('{type?}/', [QuizController::class, 'index'])->name('quiz.home');
Route::post('/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/result', [QuizController::class, 'result'])->name('quiz.result');
