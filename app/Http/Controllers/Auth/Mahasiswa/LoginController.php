<?php

namespace App\Http\Controllers\Auth\Mahasiswa;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function create(): Response
    {
        return response()->view('auth.mahasiswa.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'nim' => ['required', 'max:10'],
            'password' => ['required'],
        ]);

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('mahasiswa.pengaduanSaya.index'));
        }

        return back()->withErrors([
            'failedLogin' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
