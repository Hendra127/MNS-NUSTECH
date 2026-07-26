<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CmDoneNotification extends Notification
{
    use Queueable;

    protected $cm;

    public function __construct($cm)
    {
        $this->cm = $cm;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => 'CM Telah Selesai (Site CLEAR)',
            'message' => 'Pengajuan CM dengan nomor ' . $this->cm->nomor . ' telah berstatus DONE dan site sudah CLEAR.',
            'url'     => route('cm.index', ['search' => $this->cm->nomor]),
            'type'    => 'CM'
        ];
    }
}
