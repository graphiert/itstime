<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Discord\Discord;

class ConfigureNotificationController extends Controller
{
    public function channel(Request $Request)
    {
        $tok = ActionToken::where('token', $request->input('token'))->first();
        if(!$tok) {
            return redirect()->route('dashboard')
                ->with('message', "No token specified or token not recognized.")
                ->with('type', 'red');
        }

        if($tok->activity !== "requestDestinationChannel") {
            return redirect()->route('dashboard')
                ->with('message', "Activity unknown.")
                ->with('type', 'red');
        }

        $loggedIn = auth()->user();
        $channelId = $request->input('c');
        $userId = $request->input('u');

        if (
            $loggedIn->discord_id !== $userId &&
            $loggedIn->discord_id !== $tok->discord_id &&
            $userId !== $tok->discord_id
        ) {
            return redirect()->route('dashboard')
                ->with('message', "User unknown.")
                ->with('type', 'red');
        } else {
            $loggedIn->update(["channel_id" => $channelId]);
            $tok->delete();
            return redirect()->route('dashboard')
                ->with('message', "Channel destination updated.")
                ->with('type', 'green');
        }
    }

    public function direct(Request $request)
    {
        $loggedIn = auth()->user();
        $channelId = app(Discord::class)->getPrivateChannel($loggedIn->discord_id);
        $loggedIn->update(["channel_id" => $channelId]);
        return redirect()->route('dashboard')
            ->with('message', "Channel destination updated.")
            ->with('type', 'green');
    }
}
