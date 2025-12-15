<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'category',
        'subject',
        'color',
        'icon',
        'order_number',
        'estimated_duration',
        'total_sections',
        'total_lessons',
        'difficulty_level',
        'is_published',
        'is_featured',
        'is_free',
        'learning_objectives',
        'prerequisites',
        'thumbnail_path',
        'introduction_text',
        'intro_video_url',
    ];

    protected $casts = [
        'learning_objectives' => 'array',
        'prerequisites' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'is_free' => 'boolean',
        'order_number' => 'integer',
        'estimated_duration' => 'integer',
        'total_sections' => 'integer',
        'total_lessons' => 'integer',
    ];

    /**
     * Get the sections for this module
     */
    public function sections(): HasMany
    {
        return $this->hasMany(LearningModuleSection::class, 'learning_module_id')->orderBy('order_number');
    }

    /**
     * Get published sections only
     */
    public function publishedSections(): HasMany
    {
        return $this->sections()->where('is_published', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by subject
     */
    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    /**
     * Scope to get published modules only
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get featured modules only
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get free modules only
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope to order by order_number
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }

    /**
     * Get the difficulty level label
     */
    public function getDifficultyLevelLabelAttribute(): string
    {
        $labels = [
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan'
        ];

        return $labels[$this->difficulty_level] ?? 'Tidak diketahui';
    }

    /**
     * Get the category label
     */
    public function getCategoryLabelAttribute(): string
    {
        $labels = [
            'SKD' => 'Seleksi Kompetensi Dasar',
            'MATEMATIKA_TERANTUNG' => 'Matematika Terantung'
        ];

        return $labels[$this->category] ?? $this->category;
    }

    /**
     * Get the subject label
     */
    public function getSubjectLabelAttribute(): string
    {
        $labels = [
            'TIU' => 'Tes Intelegensi Umum',
            'TKP' => 'Tes Karakteristik Pribadi',
            'TKA' => 'Tes Kompetensi Akademik',
            'ALJABAR' => 'Aljabar',
            'GEOMETRI' => 'Geometri',
            'TRIGONOMETRI' => 'Trigonometri',
            'STATISTIKA' => 'Statistika',
            'KALKULUS' => 'Kalkulus'
        ];

        return $labels[$this->subject] ?? $this->subject;
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Update the total sections and lessons count
     */
    public function updateCounts(): void
    {
        $this->update([
            'total_sections' => $this->sections()->count(),
            'total_lessons' => $this->sections()->withCount('lessons')->get()->sum('lessons_count')
        ]);
    }
}