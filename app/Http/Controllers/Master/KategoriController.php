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
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('master.kategori.index');
    }

    public function datatable(): DataTables
    {
        if (request()->ajax()) {
            $kategoris = Kategori::query()->latest()->get();
            return DataTables::of($kategoris)
                ->addIndexColumn()
                ->addColumn('action', fn () => '<a href="#" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i> Ubah</a> <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can fa-fw"></i> Hapus</a>')
                ->editColumn('slug', fn (Kategori $kategori) => '<span class="badge bg-success" style="font-size: 12px">' . $kategori->slug . '</span>')
                ->rawColumns(['action', 'slug'])
                ->toJson();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request): JsonResponse
    {
        Kategori::query()->create($request->validated());

        return response()->json([
            'message' => "Berhasil menambah kategori"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        //
    }

    public function slug(Request $request): JsonResponse
    {
        $slug = Kategori::query()->where('slug', Str::slug($request->name))->exists() ? Str::slug($request->name) . '-' . rand(1, 99) : Str::slug($request->name);

        return response()->json(['slug' => $slug], 200);
    }
}
