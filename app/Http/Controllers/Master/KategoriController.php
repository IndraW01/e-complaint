<?php

namespace App\Http\Controllers\Master;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\KategoriRequest;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('master.kategori.index', [
            'kategoris' => Kategori::query()->latest()->paginate(10)
        ]);
    }

    public function create(): Response
    {
        return response()->view('master.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $kategori = Kategori::query()->create($request->validated());
            $role = Role::create(['name' => 'Kepala ' . $kategori->name]);
            $role->RoleKategori()->create(['kategori_id' => $kategori->id]);

            DB::commit();

            Alert::success('Berhasil', 'Kategori berhasil ditambahkan!');
            return redirect()->route('master.kategori.index');
        } catch (Exception $exception) {
            DB::rollBack();

            Alert::error('Error', 'Message ' . $exception->getMessage());
            return redirect()->route('master.kategori.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori): Response
    {
        return response()->view('master.kategori.edit', ['kategori' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->safe()->only(['name', 'slug']));

        Alert::success('Berhasil', 'Kategori berhasil diubah!');
        return redirect()->route('master.kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Role::query()->where('id', $kategori->RoleKategori->role_id)->delete();
            $kategori->delete();

            DB::commit();

            Alert::success('Berhasil', 'Kategori berhasil dihapus!');
            return redirect()->route('master.kategori.index');
        } catch (Exception $exception) {
            DB::rollBack();

            Alert::error('Error', 'Message ' . $exception->getMessage());
            return redirect()->route('master.kategori.index');
        }
    }

    public function slug(Request $request): JsonResponse
    {
        if ($request->has('slugEdit')) {
            $slugGenerate = Str::slug($request->name);
            $slug = $slugGenerate === $request->slugEdit ? $slugGenerate : (Kategori::query()->where('slug', Str::slug($request->name))->exists() ? Str::slug($request->name) . '-' . rand(1, 99) : Str::slug($request->name));
        } else {
            $slug = Kategori::query()->where('slug', Str::slug($request->name))->exists() ? Str::slug($request->name) . '-' . rand(1, 99) : Str::slug($request->name);
        }

        return response()->json(['slugJson' => $slug], 200);
    }
}
