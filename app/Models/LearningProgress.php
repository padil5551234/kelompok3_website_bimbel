<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningProgress extends Model
{
    use HasFactory, Uuids;

    protected $table = 'learning_progress';

    protected $fillable = [
        'user_id',
        'paket_id',
        'material_id',
        'ujian_id',
        'activity_type',
        'duration_seconds',
        'progress_percentage',
        'score',
        'metadata',
        'completed_at',
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
        'progress_percentage' => 'integer',
        'score' => 'decimal:2',
        'metadata' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the package
     */
    public function paket()
    {
        return $this->belongsTo(PaketUjian::class, 'paket_id');
    }

    /**
     * Get the material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the ujian
     */
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    /**
     * Scope for material activities
     */
    public function scopeMaterialActivities($query)
    {
        return $query->whereIn('activity_type', ['material_view', 'material_complete']);
    }

    /**
     * Scope for tryout activities
     */
    public function scopeTryoutActivities($query)
    {
        return $query->whereIn('activity_type', ['tryout_attempt', 'tryout_complete']);
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_seconds / 3600);
        $minutes = floor(($this->duration_seconds % 3600) / 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}