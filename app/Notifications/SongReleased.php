<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SongReleased extends Notification implements ShouldQueue
{
    use Queueable;

    protected $songTitle;
    protected $owner;


    public function __construct($songTitle, $owner)
    {
        $this->songTitle = $songTitle;
        $this->owner     = $owner;
    }


    // Choose delivery channels
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    // Database notification content
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'     => 'New Song Released',
            'message'   => $this->owner . ' dropped a new song ' . $this->songTitle,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
