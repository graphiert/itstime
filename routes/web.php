<?php

use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invite/bot', [AuthController::class, 'invite'])->name('invite');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'redirectOauth'])->name('login');
    Route::get('/login/callback', [AuthController::class, 'login']);

    Route::get('/test/login', function() {
      auth()->login(User::find(1));
      return redirect()->route('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/tasks/{task}', \App\Livewire\ViewTask::class)->name('tasks.show');

    Route::get('/settings', \App\Livewire\Settings::class)->name('settings');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/account/delete', [AuthController::class, 'delete'])->name('account.delete');
});
