<?php

namespace App\Http\Controllers\Master;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return response()->view('master.user.index', [
            'users' => User::query()->with('Role')->latest()->search($request)->paginate(10),
            'roles' => ['superadmin', 'admin', 'staff'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('master.user.create', [
            'roles' => Role::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        Alert::success('Berhasil', 'User berhasil ditambahkan!');
        return redirect()->route('master.user.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return response()->view('master.user.edit', [
            'user' => $user,
            'roles' => Role::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        Alert::success('Berhasil', 'User Role berhasil diubah!');
        return redirect()->route('master.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        Alert::success('Berhasil', 'User berhasil dihapus!');
        return redirect()->route('master.user.index');
    }
}
