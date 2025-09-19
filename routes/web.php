<?php

use App\Models\User;
use App\Http\Controllers\ConfigureNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/invite/bot', function () {
    return Socialite::driver('discord')
        ->bot()
        ->permissions(274878090240)
        ->redirect();
});


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Socialite::driver('discord')
            ->scopes(['email', 'identify', 'guilds'])
            ->redirect();
    })->name('login');

    Route::get('/login/callback', function () {
        $callbackData = Socialite::driver('discord')->user();
        $user = User::updateOrCreate([
            "discord_id" => $callbackData->id,
        ], [
            "name" => $callbackData->user['global_name'],
            "username" => $callbackData->name,
            "email" => $callbackData->email,
            "avatar" => $callbackData->avatar ?? null,
            "password" => bcrypt(Str::random(18)),
        ]);
        auth()->login($user);
        return redirect()->route('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
          'user' => Auth::user(),
        ]);
    })->name('dashboard');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    Route::get('/notifiaction/channel', [ConfigureNotificationController::class, 'channel']);

    Route::post('/notifiaction/direct', [ConfigureNotificationController::class, 'direct']);

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

