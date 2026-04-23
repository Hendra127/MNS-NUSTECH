<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $todo;
    public $actionDescription;
    public $userName;

    public function __construct(\App\Models\Todo $todo, $actionDescription, $userName)
    {
        $this->todo = $todo;
        $this->actionDescription = $actionDescription;
        $this->userName = $userName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'todo_id' => $this->todo->id,
            'title' => $this->todo->title,
            'message' => "User {$this->userName} {$this->actionDescription} pada project: '{$this->todo->title}'",
            'module' => 'TODOLIST'
        ];
    }
}
