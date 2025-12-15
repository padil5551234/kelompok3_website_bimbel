<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ujian;
use App\Models\Voucher;
use App\Models\PaketUjian;
use App\Models\JawabanPeserta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paket_id',
        'user_id',
        'harga',
        'kode_pembelian',
        'batas_pembayaran',
        'status',
        'jenis_pembayaran',
        'nama_kelompok',
        'bukti_transfer',
        'catatan_pembayaran',
        'status_verifikasi',
        'catatan_admin',
        'verified_at',
        'verified_by',
        'whatsapp_admin',
        'waktu_mulai_pengerjaan',
        'waktu_selesai_pengerjaan',
    ];

    /**
     * Get the user that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the paket that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paketUjian()
    {
        return $this->belongsTo(PaketUjian::class, 'paket_id');
    }

    /**
     * Get all of the jawabanPeserta for the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jawabanPeserta()
    {
        return $this->hasMany(JawabanPeserta::class, 'pembelian_id');
    }

    /**
     * Get the voucher that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    /**
     * Get the admin who verified the payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if payment is verified
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->status_verifikasi === 'verified';
    }

    /**
     * Check if payment is pending verification
     *
     * @return bool
     */
    public function isPendingVerification()
    {
        return $this->status_verifikasi === 'pending' && $this->bukti_transfer !== null;
    }

    /**
     * Scope to get verified purchases
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->where(function($q) {
            $q->where('status_verifikasi', 'verified')
              ->orWhere('status', 'Sukses');
        });
    }

    /**
     * Scope to get purchases for a specific user
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get purchases for a specific package
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $paketId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPackage($query, $paketId)
    {
        return $query->where('paket_id', $paketId);
    }
}
