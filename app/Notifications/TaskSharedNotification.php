<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskSharedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $todo;
    public $message;

    public function __construct(\App\Models\Todo $todo, $message = null)
    {
        $this->todo = $todo;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $notifMsg = 'Tugas baru telah dibagikan: ' . $this->todo->title;
        if (!empty($this->message)) {
            $notifMsg .= ' - Pesan: "' . $this->message . '"';
        }

        return [
            'todo_id' => $this->todo->id,
            'title' => $this->todo->title,
            'message' => $notifMsg,
            'module' => 'TODOLIST'
        ];
    }
}
