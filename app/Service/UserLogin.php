<?php

namespace App\Service;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class UserLogin
{
    public function UserLogin(): Mahasiswa
    {
        return Auth::user();
    }
}
