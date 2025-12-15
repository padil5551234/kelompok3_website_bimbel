<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kode',
        'kode_provinsi', 
        'nama',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the provinsi (formasi) that owns this kabupaten
     */
    public function provinsi()
    {
        return $this->belongsTo(Formasi::class, 'kode_provinsi', 'kode');
    }

    /**
     * Scope to filter by kode provinsi
     */
    public function scopeByProvinsi($query, $kodeProvinsi)
    {
        return $query->where('kode_provinsi', $kodeProvinsi);
    }

    /**
     * Get all kabupaten for a specific provinsi
     */
    public static function getByProvinsi($kodeProvinsi)
    {
        return self::where('kode_provinsi', $kodeProvinsi)
                  ->orderBy('nama')
                  ->get();
    }

    /**
     * Get kabupaten name by kode
     */
    public static function getNamaByKode($kode)
    {
        $kabupaten = self::find($kode);
        return $kabupaten ? $kabupaten->nama : null;
    }

    /**
     * Get kode provinsi from kabupaten kode
     */
    public static function getKodeProvinsi($kodeKabupaten)
    {
        $kabupaten = self::find($kodeKabupaten);
        return $kabupaten ? $kabupaten->kode_provinsi : null;
    }
}