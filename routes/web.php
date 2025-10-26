<?php

use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invite/bot', [AuthController::class, 'invite']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'redirectOauth'])->name('login');
    Route::get('/login/callback', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/tasks/{task}', \App\Livewire\ViewTask::class)->name('tasks.view');

    Route::get('/settings', \App\Livewire\Settings::class)->name('settings');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
