<?php

use App\Http\Middleware\IsDiscordBot;
use App\Http\Controllers\Api\ChannelController;
use Illuminate\Support\Facades\Route;

Route::middleware(IsDiscordBot::class)->group(function() {
    Route::post('/channel/set', [ChannelController::class, 'channel']);
    Route::post('/direct/set', [ChannelController::class, 'direct']);
});

