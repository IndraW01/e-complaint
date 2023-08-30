<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $kategoris = DB::table('pengaduans')
            ->join('kategori_pengaduan', 'pengaduans.id', '=', 'kategori_pengaduan.pengaduan_id')
            ->rightJoin('kategoris', 'kategori_pengaduan.kategori_id', '=', 'kategoris.id')
            ->selectRaw('kategoris.name, count(pengaduans.id) as total_pengaduan')
            ->groupBy('kategoris.name')
            ->orderBy('kategoris.name')
            ->get();

        $yearNow = Carbon::now()->year;

        return response()->view('chart', [
            'kategoris' => $kategoris,
            'tahuns' => range(2019, $yearNow),
            'bulans' => array_combine(range(1, 12), [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ])
        ]);
    }

    public function chartTahun($tahun)
    {
        $pengaduans = DB::table('pengaduans')
            ->join('kategori_pengaduan', 'pengaduans.id', '=', 'kategori_pengaduan.pengaduan_id')
            ->rightJoin('kategoris', 'kategori_pengaduan.kategori_id', '=', 'kategoris.id')
            ->selectRaw('kategoris.name, MONTH(pengaduans.created_at) AS bulan, count(pengaduans.id) AS total_pengaduan')
            ->whereYear('pengaduans.created_at', $tahun)
            ->groupByRaw('kategoris.name, MONTH(pengaduans.created_at)')
            ->get();

        $kategoriName = Kategori::query()->pluck('name');
        $kategoriActive = [];
        foreach ($pengaduans as $pengaduan) {
            $kategoriActive[] = $pengaduan->name;
        }
        $kategoriNull = $kategoriName->diff($kategoriActive);
        if ($kategoriNull->count() > 0) {
            foreach ($kategoriNull as $kategori) {
                $pengaduans[] = [
                    'name' => $kategori,
                    'bulan' => null,
                    'total_pengaduan' => 0
                ];
            }
        }

        $pengaduanChart = $pengaduans->map(function ($pengaduan) {
            return collect($pengaduan);
        })->groupBy(['bulan' => function ($pengaduan) {
            return $pengaduan['name'];
        }], true)->map(function ($pengaduan) {
            $pengaduanKey = $pengaduan->mapWithKeys(function ($item) {
                if ($item['bulan'] == null) return [];
                return [$item['bulan'] => $item['total_pengaduan']];
            });
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($pengaduanKey[$i])) {
                    $pengaduanKey[$i] = 0;
                }
            }
            $pengaduanSort = $pengaduanKey->sortKeys();

            return $pengaduanSort;
        });

        return $pengaduanChart;
    }

    public function chartBulan($bulan)
    {
        $jumlahHariPerbulan = Carbon::create(2023, $bulan)->daysInMonth;

        $pengaduanMonths = Pengaduan::query()
            ->selectRaw('DAY(created_at) AS tanggal, COUNT(*) AS total_pengaduan')
            ->whereMonth('created_at', $bulan)
            ->groupByRaw('DAY(created_at)')
            ->get()
            ->map(function ($pengaduan) {
                return collect($pengaduan);
            })->groupBy(['tanggal' => function ($pengaduan) {
                return $pengaduan['tanggal'];
            }])->map(function ($pengaduan) {
                return $pengaduan->collapse();
            })->map(function ($pengaduan) {
                return $pengaduan['total_pengaduan'];
            });
        for ($i = 1; $i <= $jumlahHariPerbulan; $i++) {
            if (!isset($pengaduanMonths[$i])) {
                $pengaduanMonths[$i] = 0;
            }
        }

        return $pengaduanMonths->sortKeys();
    }
}
