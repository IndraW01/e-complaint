<?php

namespace App\Http\Controllers\All;

use Exception;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Mail\PengaduanStatus;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Exports\PengaduanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FotoPengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PengaduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->only(['index', 'export', 'exportable']);
        $this->middleware('auth:web,mahasiswa')->only('show');
    }

    public function index(Request $request): Response
    {
        return response()->view('all.pengaduan.index-all', [
            'pengaduans' => Pengaduan::query()->with(['Kategoris', 'Tiket' => ['Mahasiswa' => ['Jurusan']]])->latest()->search($request)->role()->paginate(10)->withQueryString(),
            'statuses' => collect(['pending', 'process', 'success', 'failed']),
            'jurusans' => Jurusan::query()->orderBy('name')->pluck('name'),
            'kategoris' => Kategori::query()->orderBy('name')->pluck('name'),
        ]);
    }

    public function show(Pengaduan $pengaduan): Response
    {
        if (Auth::guard('mahasiswa')->check() && Auth::guard('mahasiswa')->id() != $pengaduan->Tiket->Mahasiswa->id) return abort(403);
        if ((Auth::guard('web')->check() &&
                Auth::guard('web')->user()->role->name != 'Admin' &&
                Auth::guard('web')->user()->role->name != 'Superadmin') &&
            !in_array(Auth::guard('web')->user()->role->RoleKategori->Kategori->id, $pengaduan->Kategoris->pluck('id')->toArray())
        ) return abort(403);

        return response()->view('all.pengaduan.show', [
            'pengaduan' => $pengaduan->load(['Tiket' => [
                'Mahasiswa' => [
                    'Jurusan'
                ]
            ], 'Kategoris', 'FotoPengaduans'])
        ]);
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $this->authorize('updateStatus', $pengaduan);

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['success', 'process', 'failed'])],
            'fotos' => ['required_if:status,success', 'array'],
            'fotos.*' => [File::types(['jpg', 'png', 'jpeg', 'svg',])
                ->max(2048)],
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first('fotos'));
            return back();
        }

        $validateData = $validator->safe()->only('status');
        $fotoPengaduanSuccess = $pengaduan->FotoPengaduans()->foto(true);

        try {
            if ($request->has('fotos')) {
                $fotos = collect([]);
                foreach ($request->file('fotos') as $foto) {
                    $fotoNameFix = 'pengaduanSuccess-' . time() . '-' . rand(0, 9999) . '-' . $foto->getClientOriginalName();

                    Storage::disk('public')->put('pengaduan/admin/' . $fotoNameFix, file_get_contents($foto));

                    $fotos->push(['name' => $fotoNameFix, 'isAdmin' => true]);
                }
                // Pengaduan Foto Create
                $pengaduan->FotoPengaduans()->createMany($fotos);
            }

            if ($fotoPengaduanSuccess->count() > 0) {
                Storage::disk('public')->delete($fotoPengaduanSuccess->map(function ($item) {
                    return 'pengaduan/admin/' . $item->name;
                })->all());
                $fotoPengaduanSuccess->each(function (FotoPengaduan $fotoPengaduan) {
                    $fotoPengaduan->delete();
                });
            }

            if ($validateData['status'] == 'success') {
                Mail::to($pengaduan->Tiket->Mahasiswa->email)->send(new PengaduanStatus($pengaduan->load(['Tiket' => ['Mahasiswa']])));
            }

            $pengaduan->update($validateData);

            DB::commit();

            Alert::success('Berhasil', 'Status berhasil diubah!');
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();

            if ($request->has('fotos')) {
                Storage::disk('public')->delete($fotos->map(function ($item) {
                    return 'pengaduan/admin/' . $item['name'];
                })->all());
            }

            Alert::error('Gagal', 'Error ubah status ' . $exception->getMessage());
        }
    }

    public function updateRating(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $this->authorize('updateRating', $pengaduan);

        $validateData = $request->validate([
            'rating' => ['required', Rule::in([1, 2, 3, 4, 5])],
        ]);

        $pengaduan->update($validateData);

        Alert::success('Berhasil', 'Rating berhasil ditambahkan!');
        return redirect()->back();
    }

    public function export()
    {
        $this->authorize('exportPengaduan', Pengaduan::class);

        return view('all.pengaduan.export', [
            'statuses' => collect(['pending', 'process', 'success', 'failed']),
            'jurusans' => Jurusan::query()->orderBy('name')->get(['id', 'name']),
            'kategoris' => Kategori::query()->orderBy('name')->pluck('name'),
        ]);
    }

    public function exportable(Request $request)
    {
        $this->authorize('exportPengaduan', Pengaduan::class);

        $request->validate([
            'searchJurusan' => ['nullable', Rule::exists('jurusans', 'name')],
            'searchStatus' => ['nullable', Rule::in(['pending', 'process', 'success', 'failed'])],
        ]);

        try {
            return Excel::download(new PengaduanExport($request), 'pengaduan.xlsx');
        } catch (Exception $exception) {
            Alert::error('Gagal', 'Export pengaduan gagal!');
            return redirect()->back();
        }
    }
}
