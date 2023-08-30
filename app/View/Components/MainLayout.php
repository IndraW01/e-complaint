<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PengaduanNotification;
use Illuminate\Database\Eloquent\Builder;

class MainLayout extends Component
{
    public string $title;
    public $pengaduanNotification;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = null)
    {
        $this->title = $title ?? config('app.name');
        if (Auth::guard('web')->check()) {
            if (
                Auth::guard('web')->user()->role->name == 'Admin' ||
                Auth::guard('web')->user()->role->name == 'Superadmin'
            ) {
                $this->pengaduanNotification = PengaduanNotification::query()->with(['Mahasiswa', 'Pengaduan'])->latest()->where('is_active', true)->get();
            } else {
                $this->pengaduanNotification = PengaduanNotification::query()->with(['Mahasiswa', 'Pengaduan'])->latest()->whereHas('Pengaduan.Kategoris', function (Builder $query) {
                    $query->where('kategoris.name', Auth::guard('web')->user()->load(['Role' => ['RoleKategori' => ['Kategori']]])->Role->RoleKategori->Kategori->name);
                })->where('is_active', true)->get();
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main');
    }
}
