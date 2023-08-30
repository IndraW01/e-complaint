<?php

namespace App\Http\Controllers\Mahasiswa;

use Exception;
use App\Models\Tiket;
use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Service\UserLogin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Events\PengaduanProcess;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\PengaduanNotification;
use App\Http\Requests\PengaduanRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PengaduanController extends Controller
{
    public function __construct(protected UserLogin $userLogin)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return response()->view('mahasiswa.pengaduan.index', [
            'pengaduans' => Pengaduan::query()->with(['Kategoris', 'Tiket' => ['Mahasiswa' => ['Jurusan']]])->latest()->whereIn('tiket_id', $this->userLogin->UserLogin()->Tiket()->pluck('id')->toArray())->search($request)->paginate(10)->withQueryString(),
            'statuses' => collect(['pending', 'process', 'success', 'failed']),
        ]);
    }

    public function create()
    {
        return response()->view('mahasiswa.pengaduan.create', [
            'pengaduanNotSuccessCount' => Pengaduan::query()->whereIn('tiket_id', $this->userLogin->UserLogin()->Tiket()->pluck('id')->all())->where('status', '!=', 'success')->count(),
            'tiketNotPengaduanCount' => Tiket::query()->where('mahasiswa_id', Auth::id())->doesntHave('Pengaduan')->get(),
        ]);
    }

    public function store(PengaduanRequest $request)
    {
        $validateData = $request->validated();

        $validateDataPengaduan = $request->only(['title', 'deskripsi']);
        $validateDataPengaduan['slug'] = Str::slug($validateDataPengaduan['title']);

        $fotos = collect([]);

        DB::beginTransaction();
        try {
            foreach ($request->file('fotos') as $foto) {
                $fotoNameFix = 'pengaduanMasuk-' . time() . '-' . rand(0, 9999) . '-' . $foto->getClientOriginalName();

                Storage::disk('public')->put('pengaduan/' . $fotoNameFix, file_get_contents($foto));

                $fotos->push(['name' => $fotoNameFix]);
            }

            // Tiket Where
            $tiket = Tiket::query()->firstWhere('token', $validateData['token']);
            // Pengaduan Create
            $pengaduan = $tiket->Pengaduan()->create($validateDataPengaduan);
            // Pengaduan Kategori Create
            $pengaduan->Kategoris()->sync($validateData['kategoris']);
            // Pengaduan Foto Create
            $pengaduan->FotoPengaduans()->createMany($fotos);

            // Kirim notifikasi email & kirim notifikasi pengaduan
            PengaduanProcess::dispatch($pengaduan);
            PengaduanNotification::dispatch($pengaduan);

            DB::commit();

            return response()->json([
                'success' => 'Pengaduan berhasil dibuat'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            Storage::disk('public')->delete($fotos->map(function ($item) {
                return 'pengaduan/' . $item['name'];
            })->all());

            return response()->json([
                'error' => 'Pengaduan gagal dibuat ' . $exception->getMessage()
            ], 422);
        }
    }

    public function storeToken(Request $request)
    {
        $validateData =  $request->validate([
            'token' => ['required', Rule::unique('tikets', 'token'), 'uuid']
        ]);

        $this->userLogin->UserLogin()->Tiket()->create($validateData);

        return response()->json(['success' => 'Tiket berhasil dibuat']);
    }

    public function cekPengaduan()
    {
        if (Tiket::query()->where('mahasiswa_id', Auth::id())->doesntHave('Pengaduan')->count() > 0) {
            return view('mahasiswa.pengaduan.create-ajax', [
                'success' => true,
                'tiket' => Tiket::query()->where('mahasiswa_id', Auth::id())->doesntHave('Pengaduan')->first('token'),
                'kategoris' => Kategori::query()->orderBy('name')->get()
            ]);
        }

        return view('mahasiswa.pengaduan.create-ajax', [
            'success' => false
        ]);;
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $this->authorize('destroy', $pengaduan);

        // Hapus Foto
        foreach ($pengaduan->FotoPengaduans->pluck('name') as $fotoPengaduan) {
            Storage::disk('public')->delete('pengaduan/' . $fotoPengaduan);
        }
        // Hapus Pengaaduan dan tiket
        $pengaduan->delete();
        Tiket::query()->where('id', $pengaduan->tiket_id)->delete();

        Alert::success('Berhasil', 'Pengaduan berhasil dihapus!');
        return redirect()->back();
    }
}
