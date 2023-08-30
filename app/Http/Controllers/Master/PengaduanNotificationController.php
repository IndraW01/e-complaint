<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\PengaduanNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PengaduanNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, PengaduanNotification $pengaduanNotification): JsonResponse
    {
        DB::beginTransaction();
        try {
            $pengaduanNotification->update([
                'is_active' => false
            ]);

            DB::commit();
            return response()->json($pengaduanNotification->Pengaduan);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Update Notif ' . $e->getMessage()], 422);
        }
    }
}
