<?php

namespace App\Exports;

use App\Models\Prodi;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\Formasi;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    public function query()
    {
        return User::query()
                    ->with('roles', 'usersDetail')
                    ->role('user')
                    ->orderBy('created_at');
    }

    function getWilayahName($id) {
        return $id ? Wilayah::find($id) : null;
    }

    function getProdi($id)
    {
        return $id ? Prodi::find($id) : null;
    }

    function getFormasi($id)
    {
        return $id ? Formasi::find($id) : null;
    }

    public function map($user): array
    {
        $usersDetail = $user->usersDetail;

        $provinsi = $usersDetail ? $usersDetail->provinsi : null;
        $kabupaten = $usersDetail ? $usersDetail->kabupaten : null;
        $kecamatan = $usersDetail ? $usersDetail->kecamatan : null;
        $prodi = $usersDetail ? $usersDetail->prodi : null;
        $penempatan = $usersDetail ? $usersDetail->penempatan : null;

        return [
            $user->id,
            $user->email,
            $user->name,
            $usersDetail ? $usersDetail->no_hp : '',
            $provinsi ? ($this->getWilayahName($provinsi)?->nama ?? '') : '',
            $kabupaten ? ($this->getWilayahName($kabupaten)?->nama ?? '') : '',
            $kecamatan ? ($this->getWilayahName($kecamatan)?->nama ?? '') : '',
            $usersDetail ? $usersDetail->asal_sekolah : '',
            $prodi ? ($this->getProdi($prodi)?->nama ?? '') : '',
            $penempatan ? ($this->getFormasi($penempatan)?->nama ?? '') : '',
            $usersDetail ? $usersDetail->instagram : '',
            $user->profile_photo_url,
            $user->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Email',
            'Nama',
            'No. HP',
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'Asal Sekolah',
            'Prodi',
            'Penempatan',
            'Instagram',
            'Link Foto Profil',
            'Tanggal Pembuatan Akun',
        ];
    }
}
