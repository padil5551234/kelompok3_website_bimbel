<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningModuleSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_module_id',
        'title',
        'subtitle',
        'description',
        'order_number',
        'estimated_duration',
        'total_lessons',
        'is_published',
        'section_type',
        'section_objectives',
        'introduction_text',
        'thumbnail_path',
    ];

    protected $casts = [
        'section_objectives' => 'array',
        'is_published' => 'boolean',
        'order_number' => 'integer',
        'estimated_duration' => 'integer',
        'total_lessons' => 'integer',
    ];

    /**
     * Get the learning module this section belongs to
     */
    public function learningModule(): BelongsTo
    {
        return $this->belongsTo(LearningModule::class, 'learning_module_id');
    }

    /**
     * Get the lessons for this section
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(LearningModuleLesson::class, 'section_id')->orderBy('order_number');
    }

    /**
     * Get published lessons only
     */
    public function publishedLessons(): HasMany
    {
        return $this->lessons()->where('is_published', true);
    }

    /**
     * Scope to get published sections only
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to order by order_number
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }

    /**
     * Get the section type label
     */
    public function getSectionTypeLabelAttribute(): string
    {
        $labels = [
            'chapter' => 'Bab',
            'unit' => 'Unit',
            'lesson_group' => 'Kelompok Materi'
        ];

        return $labels[$this->section_type] ?? $this->section_type;
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Update the total lessons count
     */
    public function updateLessonCount(): void
    {
        $this->update([
            'total_lessons' => $this->lessons()->count()
        ]);
    }
}