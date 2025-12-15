<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Formasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WilayahController extends Controller
{
    /**
     * Get all provinces
     */
    public function getProvinsi(): JsonResponse
    {
        $provinsi = Formasi::where('kode', '!=', '00')
                          ->where('kode', '!=', '01')
                          ->orderBy('nama')
                          ->get(['kode', 'nama']);
        
        return response()->json([
            'success' => true,
            'data' => $provinsi
        ]);
    }

    /**
     * Get kabupaten by kode provinsi
     */
    public function getKabupaten(Request $request): JsonResponse
    {
        $request->validate([
            'kode_provinsi' => 'required|string|size:2'
        ]);

        $kodeProvinsi = $request->kode_provinsi;
        
        $kabupaten = Kabupaten::where('kode_provinsi', $kodeProvinsi)
                              ->orderBy('nama')
                              ->get(['kode', 'nama']);
        
        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }

    /**
     * Get single kabupaten info
     */
    public function getKabupatenByKode(Request $request): JsonResponse
    {
        $request->validate([
            'kode' => 'required|string|size:4'
        ]);

        $kode = $request->kode;
        
        $kabupaten = Kabupaten::find($kode);
        
        if (!$kabupaten) {
            return response()->json([
                'success' => false,
                'message' => 'Kabupaten tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }

    /**
     * Search kabupaten by name
     */
    public function searchKabupaten(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1',
            'kode_provinsi' => 'nullable|string|size:2'
        ]);

        $query = $request->q;
        $kodeProvinsi = $request->kode_provinsi;

        $kabupatenQuery = Kabupaten::where('nama', 'LIKE', "%{$query}%");
        
        if ($kodeProvinsi) {
            $kabupatenQuery->where('kode_provinsi', $kodeProvinsi);
        }

        $kabupaten = $kabupatenQuery->orderBy('nama')
                                   ->limit(10)
                                   ->get(['kode', 'nama']);
        
        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }
}