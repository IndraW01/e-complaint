<?php

namespace App\Listeners;

use App\Events\PengaduanProcess;
use App\Models\User;
use App\Notifications\EmailPengaduan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPengaduanEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PengaduanProcess $event): void
    {
        $users = User::query()->get();
        foreach ($users as $user) {
            Notification::send($user, new EmailPengaduan($event->pengaduan));
            sleep(3);
        }
    }
}
