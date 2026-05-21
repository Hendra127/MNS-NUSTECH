<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CsrApprovalNotification extends Notification
{
    use Queueable;

    protected $csr;
    protected $message;
    protected $module;

    /**
     * Create a new notification instance.
     */
    public function __construct($model, $message, $module = 'CSR')
    {
        $this->csr = $model;
        $this->message = $message;
        $this->module = $module;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'csr_id'  => $this->csr->id,
            'nomor'   => $this->csr->nomor,
            'message' => $this->message,
            'module'  => $this->module,
        ];
    }
}
