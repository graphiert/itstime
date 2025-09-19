<?php

use App\Models\ActionToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use NotificationChannels\Discord\Discord;

Route::middleware('auth')->group(function() {
    Route::post('/action/generate', function(Request $request) {
        $activity = $request->input('activity');
        $discord_id = $request->input('discord_id');
        $token = str()->random(12);

        $exists = ActionToken::where('discord_id', $discord_id)->first();
        if($exists) {
            $exists->delete();
        }

        ActionToken::create(compact('activity', 'token', 'discord_id'));
        return response()->json([
            "message" => "Action Key generated.",
            "data" => compact('activity', 'token', 'discord_id'),
        ]);
    });
});

