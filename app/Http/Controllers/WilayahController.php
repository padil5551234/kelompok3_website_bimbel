<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function getProvince($id)
    {
        $province = Wilayah::where('kode', $id)->first();
        return response()->json($province);
    }

    public function getRegency($id)
    {
        // Get a single regency by exact kode match (used for displaying user details)
        $regency = Wilayah::where('kode', $id)->first();
        return response()->json($regency);
    }

    public function getDistrict($id)
    {
        // Get a single district by exact kode match (used for displaying user details)
        $district = Wilayah::where('kode', $id)->first();
        return response()->json($district);
    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $provinsi = $request->input('provinsi');
        $kabupaten = $request->input('kabupaten');

        $query = Wilayah::where('nama', 'like', '%' . $term . '%');

        if (!$provinsi && !$kabupaten) {
            // Provinsi - tidak memiliki titik dalam kode
            $query->whereRaw("kode NOT LIKE '%.%'");
        }

        if ($provinsi) {
            // Kabupaten - kode diawali dengan kode provinsi diikuti titik
            $query->where('kode', 'like', $provinsi . '.%')
                  ->whereRaw("kode NOT LIKE '%.%.%'"); // Memastikan hanya memiliki satu titik
        }

        if ($kabupaten) {
            // Kecamatan - kode diawali dengan kode kabupaten diikuti titik
            $query->where('kode', 'like', $kabupaten . '.%')
                  ->whereRaw("kode LIKE '%.%.%'"); // Memastikan memiliki dua titik
        }

        $results = $query->get();
        
        return response()->json($results);
    }

    public function getProvinces()
    {
        // Provinsi - tidak memiliki titik dalam kode
        $provinces = Wilayah::whereRaw("kode NOT LIKE '%.%'")->orderBy('nama')->get();
        return response()->json($provinces);
    }

    public function getRegencies($provinceId)
    {
        // Get all regencies (kabupaten/kota) for a specific province
        $regencies = Wilayah::where('kode', 'like', $provinceId . '.%')
                           ->whereRaw("kode NOT LIKE '%.%.%'") // Exclude districts
                           ->orderBy('nama')
                           ->get();
        return response()->json($regencies);
    }

    public function getDistricts($regencyId)
    {
        // Get all districts (kecamatan) for a specific regency
        $districts = Wilayah::where('kode', 'like', $regencyId . '.%')
                           ->whereRaw("kode LIKE '%.%.%'") // Only districts
                           ->orderBy('nama')
                           ->get();
        return response()->json($districts);
    }
}