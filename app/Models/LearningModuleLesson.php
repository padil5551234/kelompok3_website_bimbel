<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningModuleLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'subtitle',
        'description',
        'order_number',
        'estimated_duration',
        'lesson_type',
        'is_published',
        'is_mandatory',
        'content',
        'video_url',
        'document_path',
        'external_link',
        'quiz_data',
        'exercise_data',
        'interactive_data',
        'notes',
        'thumbnail_path',
        'views_count',
        'completion_rate',
    ];

    protected $casts = [
        'quiz_data' => 'array',
        'exercise_data' => 'array',
        'interactive_data' => 'array',
        'is_published' => 'boolean',
        'is_mandatory' => 'boolean',
        'order_number' => 'integer',
        'estimated_duration' => 'integer',
        'views_count' => 'integer',
        'completion_rate' => 'integer',
    ];

    /**
     * Get the section this lesson belongs to
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(LearningModuleSection::class, 'section_id');
    }

    /**
     * Get the learning module through the section
     */
    public function learningModule(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            LearningModule::class,
            LearningModuleSection::class,
            'id',
            'id',
            'section_id',
            'learning_module_id'
        );
    }

    /**
     * Scope to get published lessons only
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get mandatory lessons only
     */
    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    /**
     * Scope to order by order_number
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }

    /**
     * Get the lesson type label
     */
    public function getLessonTypeLabelAttribute(): string
    {
        $labels = [
            'video' => 'Video',
            'text' => 'Teks',
            'quiz' => 'Kuis',
            'exercise' => 'Latihan',
            'document' => 'Dokumen',
            'interactive' => 'Interaktif'
        ];

        return $labels[$this->lesson_type] ?? $this->lesson_type;
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Get the document URL
     */
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_path ? asset('storage/' . $this->document_path) : null;
    }

    /**
     * Increment views count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Update completion rate
     */
    public function updateCompletionRate($rate): void
    {
        $this->update(['completion_rate' => $rate]);
    }

    /**
     * Check if lesson is downloadable
     */
    public function isDownloadable(): bool
    {
        return in_array($this->lesson_type, ['document', 'video']) && ($this->document_path || $this->video_url);
    }
}