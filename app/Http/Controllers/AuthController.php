<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
  public function invite()
  {
    return Socialite::driver('discord')
      ->bot()
      ->permissions(274878090240)
      ->redirect();
  }
  
  public function redirectOauth()
  {
    return Socialite::driver('discord')
      ->scopes(['email', 'identify'])
      ->redirect();
  }
  
  public function login()
  {
    $callbackData = Socialite::driver('discord')->stateless()->user();
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
  }
  
  public function logout()
  {
    auth()->logout();
    return redirect('/');
  }
  
  public function delete()
  {
    auth()->user()->delete();
    auth()->logout();
    return redirect('/');
  }
}
