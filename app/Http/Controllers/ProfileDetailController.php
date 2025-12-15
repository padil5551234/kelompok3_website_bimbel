<?php

namespace App\Http\Controllers;

use App\Models\UsersDetail;
use App\Models\Kabupaten;
use App\Models\Formasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileDetailController extends Controller
{
    /**
     * Display the user's profile detail form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        
        // Get or create user detail
        $userDetail = $user->usersDetail ?? new UsersDetail();
        
        // Get all provinces for dropdown
        $provinsi = Formasi::where('kode', '!=', '00')
                          ->where('kode', '!=', '01')
                          ->orderBy('nama')
                          ->get(['kode', 'nama']);
        
        // Get kabupaten based on selected province
        $kabupaten = collect();
        if ($userDetail->kode_provinsi) {
            $kabupaten = Kabupaten::where('kode_provinsi', $userDetail->kode_provinsi)
                                  ->orderBy('nama')
                                  ->get(['kode', 'nama']);
        }

        return view('profile.detail-edit', [
            'user' => $user,
            'userDetail' => $userDetail,
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
        ]);
    }

    /**
     * Update the user's profile detail information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'no_hp' => ['required', 'string', 'max:20'],
            'kode_provinsi' => ['required', 'string', 'size:2', Rule::exists('formasi', 'kode')],
            'kode_kabupaten' => ['nullable', 'string', 'size:4', Rule::exists('kabupaten', 'kode')],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'asal_sekolah' => ['nullable', 'string', 'max:255'],
            'sumber_informasi' => ['array'],
            'sumber_informasi.*' => ['string', 'max:255'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'penempatan' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'nama_kelompok' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();
        
        // Validate that kabupaten belongs to selected province
        if ($request->kode_kabupaten) {
            $kabupatenExists = Kabupaten::where('kode', $request->kode_kabupaten)
                                       ->where('kode_provinsi', $request->kode_provinsi)
                                       ->exists();
            
            if (!$kabupatenExists) {
                return redirect()->back()
                    ->withErrors(['kode_kabupaten' => 'Kabupaten yang dipilih tidak valid untuk provinsi ini.'])
                    ->withInput();
            }
        }

        try {
            DB::beginTransaction();
            
            // Update or create user detail
            $userDetail = UsersDetail::updateOrCreate(
                ['id' => $user->id],
                [
                    'no_hp' => $request->no_hp,
                    'kode_provinsi' => $request->kode_provinsi,
                    'kode_kabupaten' => $request->kode_kabupaten,
                    'kecamatan' => $request->kecamatan,
                    'asal_sekolah' => $request->asal_sekolah,
                    'sumber_informasi' => $request->sumber_informasi,
                    'prodi' => $request->prodi,
                    'penempatan' => $request->penempatan,
                    'instagram' => $request->instagram,
                    'nama_kelompok' => $request->nama_kelompok,
                ]
            );
            
            DB::commit();
            
            return redirect()->route('profile.detail.edit')
                           ->with('status', 'profile-detail-updated');
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                           ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Get kabupaten by province (AJAX endpoint)
     */
    public function getKabupaten(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'kode_provinsi' => ['required', 'string', 'size:2']
        ]);

        $kabupaten = Kabupaten::where('kode_provinsi', $request->kode_provinsi)
                              ->orderBy('nama')
                              ->get(['kode', 'nama']);
        
        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }

    /**
     * Get current user profile data (for API)
     */
    public function getProfileData(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $userDetail = $user->usersDetail;
        
        if (!$userDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Data profil tidak ditemukan'
            ], 404);
        }

        // Get nama provinsi dan kabupaten
        $provinsi = $userDetail->provinsi ? $userDetail->provinsi->nama : null;
        $kabupaten = $userDetail->kabupaten ? $userDetail->kabupaten->nama : null;

        return response()->json([
            'success' => true,
            'data' => [
                'no_hp' => $userDetail->no_hp,
                'kode_provinsi' => $userDetail->kode_provinsi,
                'nama_provinsi' => $provinsi,
                'kode_kabupaten' => $userDetail->kode_kabupaten,
                'nama_kabupaten' => $kabupaten,
                'kecamatan' => $userDetail->kecamatan,
                'asal_sekolah' => $userDetail->asal_sekolah,
                'sumber_informasi' => $userDetail->sumber_informasi,
                'prodi' => $userDetail->prodi,
                'penempatan' => $userDetail->penempatan,
                'instagram' => $userDetail->instagram,
                'nama_kelompok' => $userDetail->nama_kelompok,
            ]
        ]);
    }
}