<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperpowerController;
use App\Http\Controllers\TrainingController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/generate', [SuperpowerController::class, 'generate'])->name('generate');
Route::post('/generate_training', [TrainingController::class, 'generate_training'])->name('generate_training');
Route::post('/train', [TrainingController::class, 'train'])->name('train');

// Protected route example:
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // make a dashboard.blade.php
    });
    Route::get('/superpower', [SuperpowerController::class, 'showSuperpowerPage'])->name('superpower.page');
    Route::get('/training', [TrainingController::class, 'showTrainingPage'])->name('training.page');
});