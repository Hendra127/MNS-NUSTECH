<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusHoldNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'site_id' => $this->data->site_id,
            'nama_lokasi' => $this->data->nama_lokasi,
            'user_name' => $this->user->name,
            'message' => "{$this->user->name} telah mengubah status site <a href=\"/PMLiberta?search={$this->data->site_id}\" style=\"text-decoration: underline; color: inherit;\"><b>{$this->data->site_id} {$this->data->nama_lokasi}</b></a> menjadi <b>HOLD</b>.",
            'type' => 'status_hold',
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
