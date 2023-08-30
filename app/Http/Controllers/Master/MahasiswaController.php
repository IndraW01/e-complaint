<?php

namespace App\Http\Controllers\Master;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\MahasiswaExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MahasiswaRequest;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return response()->view('master.mahasiswa.index', [
            'mahasiswas' => Mahasiswa::query()->with('Jurusan')->latest()->search($request)->paginate(10),
            'jurusans' => Jurusan::query()->orderBy('name')->pluck('name'),
            'angkatans' => range(2018, date('Y')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('master.mahasiswa.create', [
            'jurusans' => Jurusan::query()->orderBy('name')->get(['id', 'name']),
            'angkatans' => range(2018, date('Y')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request): RedirectResponse
    {
        $validateData = $request->validated();
        $validateData['password'] = 'password';

        Mahasiswa::create($validateData);

        Alert::success('Berhasil', 'Mahasiswa berhasil ditambahkan!');
        return redirect()->route('master.mahasiswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa): Response
    {
        return response()->view('master.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'jurusans' => Jurusan::query()->orderBy('name')->get(['id', 'name']),
            'angkatans' => range(2018, date('Y'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($request->validated());

        Alert::success('Berhasil', 'Mahasiswa berhasil diubah!');
        return redirect()->route('master.mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        Alert::success('Berhasil', 'Mahasiswa berhasil dihapus!');
        return redirect()->route('master.mahasiswa.index');
    }

    public function export()
    {
        return view('master.mahasiswa.export');
    }

    public function exportable(Request $request)
    {
        $validateData =  $request->validate([
            'jurusan' => ['required', Rule::exists('jurusans', 'id')],
            'angkatan' => ['nullable']
        ]);

        if (!collect($validateData)->has('angkatan')) {
            $validateData['angkatan'] = null;
        }

        if (Mahasiswa::query()->where('jurusan_id', $validateData['jurusan'])->doesntExist()) {
            Alert::error('Gagal', 'Mahasiswa dengan jurusan tidak ada!');
            return redirect()->back();
        }

        return Excel::download(new MahasiswaExport($validateData), 'mahasiswa.xlsx');
    }
}
