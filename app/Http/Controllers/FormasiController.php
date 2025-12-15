<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Formasi;
use Illuminate\Http\Request;

class FormasiController extends Controller
{
    public function getAllProdi(Request $request)
    {
        $search = $request->input('search'); // Ambil parameter 'search' dari query string

        $prodi = Prodi::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->get();

        return response()->json($prodi);
    }

    public function getProdi($kode)
    {
        $prodi = Prodi::find($kode);
        if (!$prodi) {
            return response()->json(['error' => 'Prodi tidak ditemukan'], 404);
        }
        return response()->json($prodi);
    }

    public function getAllFormasi(Request $request)
    {
        $search = $request->input('search'); // Ambil parameter 'search' dari query string

        $formasi = Formasi::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->get();

        return response()->json($formasi);
    }

    public function getFormasi($kode)
    {
        $formasi = Formasi::find($kode);
        if (!$formasi) {
            return response()->json(['error' => 'Formasi tidak ditemukan'], 404);
        }
        return response()->json($formasi);
    }
}
