<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionToken extends Model
{
    protected $fillable = [
        'token',
        'activity',
        'discord_id'
    ];

    protected function casts(): array
    {
        return [
            'token' => 'hashed'
        ];
    }
}
