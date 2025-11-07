<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Discord\Discord;

class ChannelController extends Controller
{
  public function channel(Request $request)
  {
    $userId = $request->input('u');
    $user = User::where('discord_id', $userId)->first();
    if(!$user) {
      return response()->json([
        "success" => false,
        "message" => "User not registered."
      ]);
    }
    
    $channelId = $request->input('c');
    $userChannel = User::where('channel_id', $channelId);
    if($userChannel->count() >= 1 && $userChannel->first()->discord_id != $userId) {
      return response()->json([
        "success" => false,
        "message" => "Someone has already used this channel."
      ]);
    }
    
    $discordChannel = Http::withHeaders([
      "Authorization" => 'Bot '.env('DISCORD_BOT_TOKEN')
    ])->get('https://discord.com/api/channels/'.$channelId)->json();
    
    $channelName = $discordChannel["name"];
    $guildId = $discordChannel["guild_id"];
    
    $discordGuild = Http::withHeaders([
      "Authorization" => 'Bot '.env('DISCORD_BOT_TOKEN')
    ])->get('https://discord.com/api/guilds/'.$guildId)->json();
    
    $guildName = $discordGuild["name"];
    
    $user->update([
      "guild_id" => $guildId,
      "channel_id" => $channelId,
      "channel_name" => $guildName . " #" . $channelName
    ]);
    
    return response()->json([
      "success" => true,
      "message" => "Channel destination updated.",
      "data" => [
        "channel_name" => $channelName,
        "guild_name" => $guildName,
      ]
    ]);
  }
  
  public function direct(Request $request)
  {
    $userId = $request->input('u');
    $user = User::where('discord_id', $userId)->first();
    if(!$user) {
      return response()->json([
        "success" => false,
        "message" => "User not registered."
      ]);
    }
    $channelId = app(Discord::class)->getPrivateChannel($userId);
    
    $discordChannel = Http::withHeaders([
      "Authorization" => 'Bot '.env('DISCORD_BOT_TOKEN')
    ])->get('https://discord.com/api/channels/'.$channelId)->json();

    $channelName = $discordChannel["recipients"][0]["global_name"] . "'s Direct Message";

    $user->update([
      "channel_id" => $channelId,
      "guild_id" => null,
      "mention_everyone" => false,
      "channel_name" => $channelName
    ]);
    
    return response()->json([
      "success" => true,
      "message" => "Channel destination updated.",
      "data" => [
        "channel_name" => $channelName,
      ]
    ]);
  }
}
