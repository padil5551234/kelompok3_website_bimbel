<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    use HasFactory, Uuids;

    protected $table = 'live_classes';

    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'tutor_id',
        'meeting_link',
        'meeting_password',
        'platform',
        'scheduled_at',
        'duration_minutes',
        'max_participants',
        'status',
        'materials',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'materials' => 'array',
    ];

    /**
     * Get the batch that owns the LiveClass
     */
    public function batch()
    {
        return $this->belongsTo(PaketUjian::class, 'batch_id');
    }

    /**
     * Get the tutor that owns the LiveClass
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the students that are enrolled in this LiveClass through the batch
     */
    public function students()
    {
        return $this->hasManyThrough(
            User::class,
            Pembelian::class,
            'paket_id', // Foreign key on pembelian table
            'id', // Foreign key on users table
            'batch_id', // Local key on live_classes table
            'user_id' // Local key on pembelian table
        )->where('pembelian.status', 'Sudah Bayar');
    }

    /**
     * Scope a query to only include upcoming classes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
                     ->where('scheduled_at', '>', now());
    }

    /**
     * Scope a query to only include completed classes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include ongoing classes
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Get platform icon
     */
    public function getPlatformIcon()
    {
        $icons = [
            'zoom' => 'fas fa-video',
            'google_meet' => 'fab fa-google',
            'teams' => 'fab fa-microsoft',
            'other' => 'fas fa-link',
        ];

        return $icons[$this->platform] ?? 'fas fa-video';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        $classes = [
            'scheduled' => 'bg-primary',
            'ongoing' => 'bg-success',
            'completed' => 'bg-secondary',
            'cancelled' => 'bg-danger',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }
}