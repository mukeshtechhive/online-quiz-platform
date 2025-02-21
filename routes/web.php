<?php

use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizTakeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Quiz Management Routes
Route::resource('quizzes', QuizController::class)->middleware('auth');

// Quiz Taking Routes
Route::get('/quizzes/{quiz}', [QuizTakeController::class, 'show'])->name('quizzes.take');
Route::post('/quizzes/{quiz}/submit', [QuizTakeController::class, 'submit'])->name('quizzes.submit');
Route::get('/quizzes/{quiz}/result', [QuizTakeController::class, 'result'])->name('quizzes.result');




// Routes for adding options to questions
Route::get('/questions/{question}/options', [QuestionOptionController::class, 'index'])->name('questions.options.index');
Route::post('/questions/{question}/options', [QuestionOptionController::class, 'store'])->name('questions.options.store');
