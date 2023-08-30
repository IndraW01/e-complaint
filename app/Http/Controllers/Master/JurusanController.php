<?php

namespace App\Http\Controllers\Master;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\JurusanRequest;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('master.jurusan.index', [
            'jurusans' => Jurusan::query()->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('master.jurusan.create', [
            'jurusan' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request): RedirectResponse
    {
        Jurusan::create($request->validated());

        Alert::success('Berhasil', 'Jurusan berhasil ditambahkan!');
        return redirect()->route('master.jurusan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan): Response
    {
        return response()->view('master.jurusan.edit', [
            'jurusan' => $jurusan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, Jurusan $jurusan): RedirectResponse
    {
        $jurusan->update($request->validated());

        Alert::success('Berhasil', 'Jurusan berhasil diubah!');
        return redirect()->route('master.jurusan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        $jurusan->delete();

        Alert::success('Berhasil', 'Jurusan berhasil dihapus!');
        return redirect()->route('master.jurusan.index');
    }
}
