<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        if (Auth::guard('web')->user()->Role->name == 'Admin' || Auth::guard('web')->user()->Role->name == 'Superadmin') {
            $kategoris = Kategori::query()->get()->map(function ($kategori) {
                return [$kategori->slug => Pengaduan::query()->selectRaw('status, count(id) as total')->whereHas('Kategoris', function (Builder $query) use ($kategori) {
                    $query->where('kategoris.name', $kategori->name);
                })->groupBy('status')->get(['status', 'total'])->mapWithKeys(function ($statuses) {
                    return [$statuses->status => $statuses->total];
                })];
            })->collapse();

            $kategoris->map(function ($kategori) {
                if ($kategori->count() == 4) {
                    return $kategori;
                }
                if (!isset($kategori['pending'])) {
                    $kategori['pending'] = 0;
                }
                if (!isset($kategori['process'])) {
                    $kategori['process'] = 0;
                }
                if (!isset($kategori['success'])) {
                    $kategori['success'] = 0;
                }
                if (!isset($kategori['failed'])) {
                    $kategori['failed'] = 0;
                }
                return $kategori;
            });

            $pengaduans = $kategoris->map(function ($kategori) {
                return $kategori->sortKeys();
            });

            return view('dashboard', [
                'pengaduan' => $pengaduans,
                'kategoris' => Kategori::query()->with(['RoleKategori' => ['Role']])->get()
            ]);
        }
        $kategoriRoles = Pengaduan::query()->selectRaw('status, count(id) as total')->role()->groupBy('status')->get(['status' . 'total'])->mapWithKeys(function ($kategori) {
            return [$kategori->status => $kategori->total];
        });

        if ($kategoriRoles->count() == 4) {
        } else {
            if (!isset($kategoriRoles['pending'])) {
                $kategoriRoles['pending'] = 0;
            }
            if (!isset($kategoriRoles['process'])) {
                $kategoriRoles['process'] = 0;
            }
            if (!isset($kategoriRoles['success'])) {
                $kategoriRoles['success'] = 0;
            }
            if (!isset($kategoriRoles['failed'])) {
                $kategoriRoles['failed'] = 0;
            }
        }

        $pengaduans = $kategoriRoles->sortKeys();

        return view('dashboard', [
            'pengaduan' => $pengaduans
        ]);
    }
}
