<?php

namespace App\Policies;

use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PengaduanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update($userMahasiswa, Pengaduan $pengaduan)
    {
        if ($userMahasiswa instanceof Mahasiswa) {
            return $userMahasiswa->Tiket()->firstWhere('id', $pengaduan->tiket_id)?->id === $pengaduan->tiket_id;
        }
        if ($userMahasiswa instanceof User) {
            return true;
        }
    }

    public function destroy(Mahasiswa $user, Pengaduan $pengaduan)
    {
        return $user->id == $pengaduan->Tiket->Mahasiswa->id;
    }

    public function updateRating(Mahasiswa $user, Pengaduan $pengaduan)
    {
        return $user->Tiket()->firstWhere('id', $pengaduan->tiket_id)?->id === $pengaduan->tiket_id;
    }

    public function updateStatus(User $user, Pengaduan $pengaduan)
    {
        return Auth::guard('web')->id() === $user->id;
    }

    public function exportPengaduan()
    {
        return Auth::guard('web')->check();
    }
}
