<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyStatistics extends Model
{
    use HasFactory, Uuids;

    protected $table = 'study_statistics';

    protected $fillable = [
        'user_id',
        'study_date',
        'total_study_time',
        'materials_viewed',
        'tryouts_completed',
        'average_score',
        'subjects_studied',
    ];

    protected $casts = [
        'study_date' => 'date',
        'total_study_time' => 'integer',
        'materials_viewed' => 'integer',
        'tryouts_completed' => 'integer',
        'average_score' => 'decimal:2',
        'subjects_studied' => 'array',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted study time
     */
    public function getFormattedStudyTimeAttribute()
    {
        $hours = floor($this->total_study_time / 3600);
        $minutes = floor(($this->total_study_time % 3600) / 60);

        if ($hours > 0) {
            return sprintf('%d jam %d menit', $hours, $minutes);
        }

        return sprintf('%d menit', $minutes);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('study_date', [$startDate, $endDate]);
    }

    /**
     * Scope for current week
     */
    public function scopeCurrentWeek($query)
    {
        return $query->whereBetween('study_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope for current month
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('study_date', now()->month)
            ->whereYear('study_date', now()->year);
    }
}