<?php

namespace App\Listeners;

use App\Events\PengaduanNotification;
use App\Models\PengaduanNotification as ModelsPengaduanNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPengaduanNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PengaduanNotification $event): void
    {
        ModelsPengaduanNotification::create([
            'mahasiswa_id' => $event->pengaduan->Tiket->mahasiswa_id,
            'pengaduan_id' => $event->pengaduan->id
        ]);
    }
}
