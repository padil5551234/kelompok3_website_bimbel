<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersDetail extends Model
{
    use HasFactory, Uuids;

    protected $table = 'users_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'no_hp',
        'kode_provinsi', // Kode provinsi (dari tabel formasi)
        'kode_kabupaten', // Kode kabupaten (dari tabel kabupaten)
        'kecamatan',
        'asal_sekolah',
        'sumber_informasi',
        'prodi',
        'penempatan',
        'instagram',
        'nama_kelompok',
    ];

    protected $casts = [
        'sumber_informasi' => 'array'
    ];

    /**
     * Get the user associated with the UsersDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    /**
     * Get the provinsi (formasi) associated with this user detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provinsi()
    {
        return $this->belongsTo(Formasi::class, 'kode_provinsi', 'kode');
    }

    /**
     * Get the kabupaten associated with this user detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kode_kabupaten', 'kode');
    }

    /**
     * Get nama provinsi
     *
     * @return string|null
     */
    public function getNamaProvinsiAttribute()
    {
        return $this->provinsi ? $this->provinsi->nama : null;
    }

    /**
     * Get nama kabupaten
     *
     * @return string|null
     */
    public function getNamaKabupatenAttribute()
    {
        return $this->kabupaten ? $this->kabupaten->nama : null;
    }

    /**
     * Set kode provinsi and clear kabupaten if province changes
     *
     * @param string $value
     */
    public function setKodeProvinsiAttribute($value)
    {
        // If province changes, clear kabupaten selection
        if ($this->kode_provinsi !== $value) {
            $this->attributes['kode_kabupaten'] = null;
        }
        $this->attributes['kode_provinsi'] = $value;
    }
}
