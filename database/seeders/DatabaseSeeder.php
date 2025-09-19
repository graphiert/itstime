<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'shirokiyo',
            'username' => 'graphiert',
            'discord_id' => '758832664630919198',
            'channel_id' => "1016965533016522762",
            'email' => "galihpujiirianto@gmail.com",
            'avatar' => "https://cdn.discordapp.com/avatars/758832664630919198/b4460cc50bdafb73908a5556f3868178.png",
            'password' => Str::random(18)
        ]);

        Task::factory(5)->create();
    }
}
