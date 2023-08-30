<?php

namespace App\Http\Controllers\All;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->view('all.profile.index', [
            'userLogin' => Auth::user(),
            'angkatans' => range(2018, date('Y')),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $validateData = $request->validated();
        DB::beginTransaction();
        try {
            $fotoDelete = Auth::user()->foto;
            $pathFotoUpdate = 'profile/' . $fotoDelete;

            if (Auth::user()->foto) {

                // Salin foto sebelum dihapus
                $temporaryPath = 'profile/temp/' . $fotoDelete;
                Storage::disk('public')->copy($pathFotoUpdate, $temporaryPath);

                // Hapus Foto sebelumnya
                Storage::disk('public')->delete($pathFotoUpdate);
            }

            // Upload Foto
            $fotoNameFix = 'profile-' . Auth::id() . '-' . time() . '-' . rand(0, 9999) . '-' . $request->foto->getClientOriginalName();

            Storage::disk('public')->put('profile/' . $fotoNameFix, file_get_contents($request->foto));

            $validateData['foto'] = $fotoNameFix;

            // Update Foto
            Auth::user()->update($validateData);

            DB::commit();

            // Jika berhasil hapus foto salinan
            if ($fotoDelete) {
                Storage::disk('public')->delete($temporaryPath);
            }

            Alert::success('Berhasil', 'Profile berhasil diubah!');
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();

            if (isset($fotoDelete) && isset($temporaryPath)) {
                Storage::disk('public')->move($temporaryPath, $pathFotoUpdate);
            }

            Storage::disk('public')->delete('profile/' . $fotoNameFix);

            Alert::error('Gagal', 'Profile gagal diubah! ' . $exception->getMessage());
            return redirect()->back();
        }
    }
}
