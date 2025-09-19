<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;


class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [DiscordChannel::class];
    }

    /**
     * Get the Discord representation of the notification.
     */
    public function toDiscord(object $notifiable)
    {
        return DiscordMessage::create(
            "DING DONG! <@". $this->user->discord_id. ">",
            [
                'title' => 'New reminder!',
                'description' => "<@" .$this->user->discord_id . "> has been requested to notify this.\nThis notification only for testing purposes.\nYou can request to notify again on dashboard.",
                'color' => hexdec('FF914D'),
                'footer' => [
                    'text' => "Test notification.",
                ],
                'timestamp' => now()->toIso8601String(),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
