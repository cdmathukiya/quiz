<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
////    return view('welcome');
//    return Inertia::render('home');
//});

use App\Http\Controllers\QuizController;

Route::get('/', [QuizController::class, 'index'])->name('quiz.home');
Route::post('/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/result', [QuizController::class, 'result'])->name('quiz.result');
