<?php

namespace App\Models;

use App\Models\Ujian;
use App\Traits\Uuids;
use App\Models\Voucher;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketUjian extends Model
{
    use HasFactory, Uuids;

    protected $table = 'paket_ujian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'level',
        'is_featured',
        'waktu_mulai',
        'waktu_akhir',
        'whatsapp_group_link',
    ];

    /**
     * The ujian that belong to the PaketUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ujian()
    {
        return $this->belongsToMany(Ujian::class);
    }

    /**
     * Get all of the pembelian for the PaketUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'paket_id', 'id');
    }

    /**
     * Get all of the voucher for the PaketUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function voucher()
    {
        return $this->hasMany(Voucher::class, 'paket_ujian_id', 'id');
    }

    /**
     * Get all of the live classes for the PaketUjian (Batch)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class, 'batch_id', 'id');
    }

    /**
     * Get all of the materials for the PaketUjian (Batch)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'batch_id', 'id');
    }

    /**
     * Get all of the bank soal for the PaketUjian (Batch)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankSoal()
    {
        return $this->hasMany(BankSoal::class, 'batch_id', 'id');
    }

}
